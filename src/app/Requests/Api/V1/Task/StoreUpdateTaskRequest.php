<?php
declare(strict_types=1);

namespace App\Requests\Api\V1\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Stringable;

class StoreUpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
        ];
    }

    public function getTitle(): string
    {
        return $this->string('title')->value();
    }
}
