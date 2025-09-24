<?php
declare(strict_types=1);

namespace App\Http\Controllers\Telegram\V1;

use App\Http\Controllers\Controller;
use App\Services\Telegram\V1\TelegramService;
use Illuminate\Http\JsonResponse;

class TelegramController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegramService,
    )
    {
    }

    public function convertToCsv(): JsonResponse
    {
        $this->telegramService->convertToCsv();
        return response()->json([
            'ok' => true,
        ]);
    }
}
