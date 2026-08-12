<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeWithTimeout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:extended {--timeout=300 : The maximum execution time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the development server with extended timeout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeout = $this->option('timeout');

        // Set max execution time for PHP
        ini_set('max_execution_time', $timeout);
        set_time_limit($timeout);

        $this->info("Starting server with {$timeout} seconds timeout...");

        $port = 8000;
        $host = '127.0.0.1';

        $command = [
            PHP_BINARY,
            '-S',
            $host . ':' . $port,
            '-t',
            base_path('public'),
            '-d',
            "max_execution_time={$timeout}",
        ];

        $process = new Process($command);
        $process->setTimeout(null);
        $process->start();

        foreach ($process as $type => $data) {
            echo $data;
        }
    }
}
