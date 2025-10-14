<?php
declare(strict_types=1);

namespace Tests\Feature\Telegram\V1;

use App\Enums\SheetFileExtEnum;
use App\Http\Controllers\Telegram\V1\TelegramController;
use Psr\SimpleCache\InvalidArgumentException;
use Tests\Services\TelegramControllerTestService;
use Tests\TestCase;
use Throwable;

class TelegramControllerTest extends TestCase
{
    private readonly TelegramControllerTestService $testService;

    protected function setUp(): void
    {
        $this->testService = app(TelegramControllerTestService::class);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $path = storage_path('app/output/example.csv');

        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function test_can_convert_docs(): void
    {
        foreach (SheetFileExtEnum::cases() as $value) {
            $testFileName = sprintf('example.%s', $value->value);
            $mockBot = $this->testService->generateMockBotForFileTest($testFileName);
            app(TelegramController::class)->convertToCsv($mockBot);
            $path = storage_path('app/output/example.csv');
            $this->assertFileExists($path);
            unlink($path);
        }
    }
}
