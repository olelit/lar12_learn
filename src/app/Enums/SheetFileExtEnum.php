<?php

namespace App\Enums;

enum SheetFileExtEnum: string
{
    case NUMBERS = 'numbers';
    case XLSX = 'xlsx';
    case XLS = 'xls';

    public static function supportedExtsStr(): string
    {
        return implode(', ', array_map(fn(SheetFileExtEnum $enum) => $enum->value, self::cases()));
    }
}
