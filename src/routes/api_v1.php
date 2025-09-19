<?php

use App\Http\Controllers\Api\V1\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class)->names('api.v1.tasks');
