<?php

namespace App\Console\Commands\Installation;

use Illuminate\Console\Command;

class Warning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installation:warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post-installation warning for the application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->warn('Run the following command to complete the installation:');
        $this->line(str_repeat(chr(9), 3).'php artisan installation');
    }
}
