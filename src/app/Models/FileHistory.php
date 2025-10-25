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
    /**
     * @return BelongsTo<Client, self>
     */
    public function client(): BelongsTo
    {
        /** @var BelongsTo<Client, self> $relation */
        $relation = $this->belongsTo(Client::class);
        return $relation;
    }
}
