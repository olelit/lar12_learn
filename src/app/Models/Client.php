<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $web_identificator
 * @property int $convert_count
 */
class Client extends Model
{
    public const int MAX_CONVERT_COUNT = 5;

    protected $hidden = [
        'user_id',
    ];

    public function getConvertCount(): int
    {
        return $this->convert_count;
    }

    public function isLimitExceeded(): bool
    {
        return $this->convert_count >= self::MAX_CONVERT_COUNT;
    }

    public function incrementConvertCount(): void
    {
        $this->convert_count += 1;
        $this->save();
    }
}
