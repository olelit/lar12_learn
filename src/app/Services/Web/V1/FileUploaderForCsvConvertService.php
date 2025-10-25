<?php
declare(strict_types=1);

namespace App\Services\Web\V1;

use App\Helpers\LangHelper;
use App\Http\Middleware\CheckClientCookie;
use App\Models\Client;
use App\Services\FileConverterService;
use App\Services\Telegram\V1\ClientService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

readonly class FileUploaderForCsvConvertService
{

    public function __construct(
        private FileConverterService $fileConverterService,
        private ClientService        $clientService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function saveAndConvert(UploadedFile $file): ?string
    {
        $path = $file->store('input');

        if ($path === false) {
            throw new Exception('Invalid upload path.');
        }

        $outerName = pathinfo($path, PATHINFO_BASENAME);
        $identififator = (string)Cookie::get(CheckClientCookie::COOKIE_NAME);

        if(empty($identififator)) {
            throw new Exception('Invalid client cookie.');
        }

        $client = $this->clientService->createOrGetByIdentificator($identififator);

        if ($client->isLimitExceeded()) {
            abort(Response::HTTP_BAD_REQUEST, LangHelper::getToCSVByKey('limit_exceeded', [
                'MAX' => Client::MAX_CONVERT_COUNT,
            ]));
        }

        $convertedPath = $this->fileConverterService->saveHistoryAndConvert($file->getClientOriginalName(), $outerName, $client);
        $client->incrementConvertCount();
        Storage::delete($path);
        return $convertedPath;
    }
}
