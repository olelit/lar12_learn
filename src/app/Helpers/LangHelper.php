<?php
declare(strict_types=1);

namespace App\Helpers;

class LangHelper
{
    /**
     * @param array<string, string> $params
     */
    public static function getToCSVByKey(string $key, array $params = []): string
    {
        $value = __("to_csv_module.{$key}", $params);
        if (!is_string($value)) {
            return '';
        }

        return $value;
    }
}
