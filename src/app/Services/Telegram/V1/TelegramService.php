<?php
declare(strict_types=1);

namespace App\Services\Telegram\V1;

use App\Helpers\LangHelper;
use App\Services\FileConverters\FileConverterFactory;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

class TelegramService
{
    public function convertToCsv(Nutgram $bot): void
    {
        $message = $bot->message();

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

        $inputDir = storage_path('app/input');
        $outputDir = storage_path('app/output');
        if (!is_dir($inputDir)) mkdir($inputDir, 0755, true);
        if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);
        $fullPath = $inputDir . '/' . $fileName;
        $file = $bot->getFile($fileId);

        if ($file === null) {
            $bot->sendMessage(LangHelper::getToCSVByKey('cant_get_file'));
            return;
        }

        $file->save($fullPath);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        try {
            $convertedFilePath = $this->findStrategyAndConvert($extension, $fullPath, $outputDir);
            if ($convertedFilePath) {
                $bot->sendDocument(
                    document: InputFile::make($convertedFilePath),
                    chat_id: $bot->chatId(),
                    caption: LangHelper::getToCSVByKey('successful_convert', ['NAME' => $fileName]),
                );
            } else {
                $bot->sendMessage(LangHelper::getToCSVByKey('convert_error'));
            }
        } catch (\InvalidArgumentException $e) {
            $bot->sendMessage(LangHelper::getToCSVByKey('unsupported_format', ['EXT' => $extension]));
        }
    }

    public function findStrategyAndConvert(string $extension, string $fullPath, string $outputDir): ?string
    {
        $converter = FileConverterFactory::make($extension);
        return $converter->convert($fullPath, $outputDir);
    }
}
