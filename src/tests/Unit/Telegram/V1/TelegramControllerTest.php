<?php
declare(strict_types=1);

namespace Telegram\V1;

use App\Http\Controllers\Telegram\V1\TelegramController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\TestCase;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Media\File;

class TelegramControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_convert_numbers_to_csv()
    {
        $fakeFile = base_path('tests/Feature/files/example.numbers');
        $outputPath = storage_path('app/output/example.csv');

        $bot = Nutgram::fake();
        /** @var Nutgram|Mockery\MockInterface $botMock */
        $botMock = Mockery::mock($bot)->makePartial();
        $file = File::fromArray([
            'file_id' => 'FAKE_FILE_ID',
            'file_unique_id' => 'FAKE_FILE_ID',
            'file_path' => $fakeFile,
        ]);

        $botMock->shouldReceive('getFile')
            ->with('FAKE_FILE_ID')
            ->andReturn(fn() => $file);

        $botMock->onMessage(function (Nutgram $bot) {
            app(TelegramController::class)->convertToCsv($bot);
        });

        $update = ['update_id' => 123456,
            'message' => [
                'message_id' => 1,
                'chat' => ['id' => 111, 'type' => 'private'],
                'date' => time(),
                'document' => ['file_id' => 'FAKE_FILE_ID', 'file_unique_id' => 'FAKE_FILE_ID', 'file_name' => 'example.numbers',]
            ]
        ];

        $bot->processUpdate(Update::fromArray($update));

        $this->assertFileExists($outputPath);
    }
}
