<?php
declare(strict_types=1);

namespace App\Services\Web\V1;

use App\Services\FileConverterService;
use Illuminate\Http\UploadedFile;

readonly class FileUploaderForCsvConvertService
{

    public function __construct(
        private FileConverterService $fileConverterService,
    )
    {
    }

    public function saveAndConvert(UploadedFile $file): string
    {
        $path = $file->store('input');
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = pathinfo($path, PATHINFO_FILENAME) . '.' . $extension;
        return $this->fileConverterService->convert($filename);
    }
}
