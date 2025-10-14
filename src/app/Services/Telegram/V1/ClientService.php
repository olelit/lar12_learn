<?php
declare(strict_types=1);

namespace App\Services\Telegram\V1;

use App\Helpers\LangHelper;
use App\Models\Client;
use App\Services\FileConverters\FileConverterFactory;
use Illuminate\Database\Eloquent\Model;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

class ClientService
{
    public function createByUserId(int $userId): Client
    {
        $client = Client::query()
            ->where('user_id', '=', $userId)
            ->firstOrNew();

        if (!$client->exists) {
            $client->user_id = $userId;
            $client->save();
        }

        return $client;
    }
}
