<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $original_name
 * @property string $outer_name
 * @property Client $client
 */
class FileHistory extends Model
{
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
