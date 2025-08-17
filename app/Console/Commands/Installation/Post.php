<?php

namespace App\Console\Commands\Installation;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Post extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installation:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post-installation tasks for the application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running post-installation tasks...');
        
        // Clear caches
        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully.');

        // Optimize the application
        Artisan::call('optimize');
        $this->info('Application optimized successfully.');

        $this->info('Post-installation tasks completed successfully.');
    }
}
