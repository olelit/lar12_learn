<?php
declare(strict_types=1);

namespace App\Resources\Api\V1\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Task $resource
 */
class StoreUpdateTaskResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
        ];
    }
}
