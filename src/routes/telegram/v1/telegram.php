<?php


use App\Http\Controllers\Telegram\V1\TelegramController;
use Illuminate\Support\Facades\Route;

Route::post('convert-to-csv', [TelegramController::class, 'convertToCsv']);
