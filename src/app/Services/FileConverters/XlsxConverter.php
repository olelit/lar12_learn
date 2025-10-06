<?php

namespace App\Services\FileConverters;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class XlsxConverter implements FileConverterStrategy
{
    public function convert(string $inputPath, string $outputDir): ?string
    {
        $fileName = pathinfo($inputPath, PATHINFO_FILENAME) . '.csv';
        $fullOutputPath = rtrim($outputDir, '/') . '/' . $fileName;

        $spreadsheet = IOFactory::load($inputPath);
        $writer = new Csv($spreadsheet);
        $writer
            ->setDelimiter(",")
            ->setSheetIndex(0)
            ->save($fullOutputPath);
        return $fullOutputPath;
    }
}

