<?php

namespace App\Console\Commands\Clients;

use App\Models\Client;
use Illuminate\Console\Command;

class ResetConvertCount extends Command
{
    protected $signature = 'app:reset-convert-count';

    protected $description = 'Reset convert counts for all clients';

    public function handle(): int
    {
        Client::query()->update(['convert_count' => 0]);
        $this->info('Convert counts have been reset for all clients.');
        return Command::SUCCESS;
    }
}
