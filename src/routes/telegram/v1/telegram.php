<?php


use App\Http\Controllers\Telegram\V1\TelegramController;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

Route::post('convert-to-csv', [TelegramController::class, 'convertToCsv']);


app(SergiX44\Nutgram\Nutgram::class)->onMessage(function (Nutgram $bot) {
    app(TelegramController::class)->convertToCsv($bot);
});
