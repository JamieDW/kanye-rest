<?php

namespace App\Console\Commands;

use App\Services\TokenService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a temporary token for the API authentication';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $token = TokenService::create();

        $this->info($token);

        return CommandAlias::SUCCESS;
    }
}
