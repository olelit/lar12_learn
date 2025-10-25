<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Client;
use App\Models\FileHistory;
use App\Services\FileConverters\FileConverterFactory;
use Illuminate\Database\Eloquent\Model;

class FileHistoryService
{
    public function createHistoryRecord(string $originalName, string $outerName, Client $client): void
    {
        $fileHist = new FileHistory();
        $fileHist->client()->associate($client);
        $fileHist->original_name = $originalName;
        $fileHist->outer_name = $outerName;
        $fileHist->save();
    }

    public function getFileHistByOuter(string $outerName): FileHistory
    {
        return FileHistory::query()
            ->where('outer_name', $outerName)
            ->firstOrFail();
    }
}
