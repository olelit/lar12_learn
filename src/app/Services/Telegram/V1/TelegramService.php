<?php
declare(strict_types=1);

namespace App\Services\Telegram\V1;

use App\Enums\SheetFileExtEnum;
use App\Helpers\LangHelper;
use App\Models\Client;
use App\Services\FileConverterService;
use App\Services\FileHistoryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

readonly class TelegramService
{
    public function __construct(
        private ClientService        $clientService,
        private FileConverterService $fileConverterService,
        private FileHistoryService   $fileHistoryService,
    )
    {
    }

    public function convertToCsv(Nutgram $bot): void
    {
        $message = $bot->message();
        $uid = $bot->userId();

        if ($uid === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('unknown_user'));
            return;
        }

        $client = $this->clientService->createByUserId($uid);

        if ($client->isLimitExceeded()) {
            $bot->sendMessage(LangHelper::getToCSVByKey('limit_exceeded', [
                'MAX' => Client::MAX_CONVERT_COUNT,
            ]));
            return;
        }

        if ($message === null || $message->document === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('doc_not_found'));
            return;
        }

        $document = $message->document;
        $fileId = $document->file_id ?? null;
        $fileName = $document->file_name ?? null;

        if ($fileId === null || $fileName === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('incorrect_data'));
            return;
        }

        $inputDir = storage_path(FileConverterService::INPUT_DIR);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $outerFileName = Str::uuid() . '.' . $extension;
        $inputFullPath = $inputDir . '/' . $outerFileName;

        $file = $bot->getFile($fileId);

        if ($file === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('cant_get_file'));
            return;
        }

        $file->save($inputFullPath);

        try {
            $convertedFilePath = $this->fileConverterService->saveHistoryAndConvert($fileName, $outerFileName, $client);
            if ($convertedFilePath) {
                $outerOnlyFileName = pathinfo($convertedFilePath, PATHINFO_FILENAME);
                $fileHistory = $this->fileHistoryService->getFileHistByOuter($outerOnlyFileName);
                $bot->sendDocument(
                    document: InputFile::make($convertedFilePath, $fileHistory->original_name),
                    chat_id: $bot->chatId(),
                    caption: LangHelper::getToCSVByKey('successful_convert', ['NAME' => $fileName]),
                );

                $client->incrementConvertCount();
                $bot->sendMessage(LangHelper::getToCSVByKey('convert_count', [
                    'COUNT' => $client->getConvertCount(),
                    'MAX' => Client::MAX_CONVERT_COUNT,
                ]));

                if ($client->isLimitExceeded()) {
                    $bot->sendMessage(LangHelper::getToCSVByKey('limit_exceeded', [
                        'MAX' => Client::MAX_CONVERT_COUNT,
                    ]));
                }

            } else {
                $bot->sendMessage(LangHelper::getToCSVByKey('convert_error'));
            }
        } catch (\InvalidArgumentException $e) {
            $bot->sendMessage($e->getMessage());
        }
    }

    public function start(Nutgram $bot): void
    {
        $uid = $bot->userId();

        if ($uid === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('unknown_user'));
            return;
        }

        $client = $this->clientService->createByUserId($uid);

        $bot->sendMessage(LangHelper::getToCSVByKey('supported_formats', [
            'EXTS' => SheetFileExtEnum::supportedExtsStr(),
        ]));

        $bot->sendMessage(LangHelper::getToCSVByKey('convert_count', [
            'COUNT' => $client->getConvertCount(),
            'MAX' => Client::MAX_CONVERT_COUNT,
        ]));
    }
}
