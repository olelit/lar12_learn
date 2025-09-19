<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Requests\Api\V1\Task\StoreUpdateTaskRequest;
use App\Resources\Api\V1\Task\StoreUpdateTaskResource;
use App\services\Api\V1\Task\TaskService;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    public function store(StoreUpdateTaskRequest $request): StoreUpdateTaskResource
    {
        $task = $this->taskService->store($request);
        return StoreUpdateTaskResource::make($task);
    }
}
