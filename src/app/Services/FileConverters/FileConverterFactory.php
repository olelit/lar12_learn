<?php

namespace App\Services\FileConverters;

use App\Enums\SheetFileExtEnum;
use App\Helpers\LangHelper;
use InvalidArgumentException;

class FileConverterFactory
{
    public static function make(string $extension): FileConverterStrategy
    {
        return match (strtolower($extension)) {
            SheetFileExtEnum::NUMBERS->value => new NumbersConverter(),
            SheetFileExtEnum::XLS->value, SheetFileExtEnum::XLSX->value, => new XlsxConverter(),
            default => throw new InvalidArgumentException(LangHelper::getToCSVByKey('unsupported_format', ['EXT' => $extension]))
        };
    }
}

