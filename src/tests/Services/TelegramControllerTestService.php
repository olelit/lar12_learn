<?php
declare(strict_types=1);

namespace Tests\Services;

use Mockery;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Testing\FakeNutgram;

class TelegramControllerTestService
{
    /**
     * @throws \Throwable
     * @throws InvalidArgumentException
     */
    public function generateMockBotForFileTest(string $fileName): Mockery\LegacyMockInterface|Mockery|FakeNutgram
    {
        $bot = FakeNutgram::fake();
        $fileData = [
            'file_id' => 'fake_id_123',
            'file_name' => $fileName,
            'mime_type' => 'test',
            'file_size' => 1024,
            'file_unique_id' => 'fake_uid_123',
        ];

        $updateArray = [
            'update_id' => 1,
            'message' => [
                'message_id' => 42,
                'date' => time(),
                'chat' => ['id' => 111, 'type' => 'private'],
                'document' => $fileData,
            ],
        ];

        $update = Update::fromArray($updateArray);
        $mockBot = Mockery::mock($bot)->makePartial();
        $mockBot->shouldReceive('getFile')->andReturn(
            File::fromArray($fileData)
        );

        /** @var  Mockery|FakeNutgram $mockBot */
        $mockBot->processUpdate($update);
        return $mockBot;
    }
}
