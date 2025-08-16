<?php

namespace App\Console\Commands\IDE;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Helper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide:helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'IDE Generator Helper';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('ide-helper:generate');
        Artisan::call('ide-helper:models -RW');
        Artisan::call('ide-helper:meta');
    }
}
