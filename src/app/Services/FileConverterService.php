<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Client;
use App\Services\FileConverters\FileConverterFactory;

class FileConverterService
{
    public const string INPUT_DIR = 'app/private/input';
    public const string OUTPUT_DIR = 'app/private/output';

    public function __construct(
        private readonly FileHistoryService $fileHistoryService,
    )
    {
    }

    public function saveHistoryAndConvert(string $originalName, string $outerName, Client $client): ?string
    {
        $originalOnlyFileName = pathinfo($originalName, PATHINFO_FILENAME);
        $outerOnlyFileName = pathinfo($outerName, PATHINFO_FILENAME);
        $this->fileHistoryService->createHistoryRecord($originalOnlyFileName, $outerOnlyFileName, $client);
        $inputDir = storage_path(self::INPUT_DIR);
        $outputDir = storage_path(self::OUTPUT_DIR);
        if (!is_dir($inputDir)) mkdir($inputDir, 0755, true);
        if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);
        $inputFullPath = $inputDir . '/' . $outerName;
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return $this->findStrategyAndConvert($extension, $inputFullPath, $outputDir);
    }

    public function findStrategyAndConvert(string $extension, string $fullPath, string $outputDir): ?string
    {
        $converter = FileConverterFactory::make($extension);
        return $converter->convert($fullPath, $outputDir);
    }
}
