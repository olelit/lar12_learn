<?php

namespace App\Services\FileConverters;

use InvalidArgumentException;

class FileConverterFactory
{
    public static function make(string $extension): FileConverterStrategy
    {
        return match (strtolower($extension)) {
            'numbers' => new NumbersConverter(),
            default => throw new InvalidArgumentException("Неизвестное расширение: $extension"),
        };
    }
}

