<?php
namespace App\Services\FileConverters;

class NumbersConverter implements FileConverterStrategy
{
    public function convert(string $inputPath, string $outputDir): ?string
    {
        $escapedInput = escapeshellarg($inputPath);
        $escapedOutput = escapeshellarg($outputDir);
        exec("libreoffice --headless --convert-to csv --outdir $escapedOutput $escapedInput", $output, $resultCode);
        if ($resultCode !== 0) {
            return null;
        }
        $fileName = pathinfo($inputPath, PATHINFO_FILENAME) . '.csv';
        return rtrim($outputDir, '/') . '/' . $fileName;
    }
}

