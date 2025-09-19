<?php
declare(strict_types=1);

namespace App\services\Api\V1\Task;
use App\Models\Task;
use App\Requests\Api\V1\Task\StoreUpdateTaskRequest;

class TaskService
{

    public function store(StoreUpdateTaskRequest $request): Task
    {
        $task = new Task();
        $task->title = $request->getTitle();
        $task->save();
        return $task;
    }
}
