<?php

namespace App\Services\FileConverters;

interface FileConverterStrategy
{
    public function convert(string $inputPath, string $outputDir): ?string;
}
