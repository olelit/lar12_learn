<?php
declare(strict_types=1);

namespace App\Services\Web\V1;

use App\Http\Middleware\CheckClientCookie;
use App\Services\FileConverterService;
use App\Services\Telegram\V1\ClientService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cookie;

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

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = pathinfo($path, PATHINFO_FILENAME) . '.' . $extension;
        $identififator = Cookie::get(CheckClientCookie::COOKIE_NAME);
        $client = $this->clientService->createOrGetByIdentificator($identififator);
        return $this->fileConverterService->saveHistoryAndConvert($file->getFilename(), $file->getClientOriginalName(), $client);
    }
}
