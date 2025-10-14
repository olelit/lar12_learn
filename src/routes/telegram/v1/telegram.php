<?php


use App\Http\Controllers\Telegram\V1\TelegramController;
use SergiX44\Nutgram\Nutgram;

app(Nutgram::class)->onMessage(function (Nutgram $bot) {
    app(TelegramController::class)->convertToCsv($bot);
});

app(Nutgram::class)->onCommand('start', function (Nutgram $bot) {
    app(TelegramController::class)->start($bot);
});
