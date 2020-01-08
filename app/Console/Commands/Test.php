<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parseLog();

        return 0;
    }

    private function parseLog()
    {
        $data = json_decode(file_get_contents('sent.log'), true)['items'];
        $emails = json_decode(file_get_contents('sent.json'), true);

        $emails = array_merge($emails, array_map(function ($message) {
            $parts = explode(' ', $message);
            return strlen($parts[3]) > 5 ? $parts[3] : $parts[7];
        }, array_column($data, 'message')));

        $emails = array_unique($emails);

        $this->info('Emails: ' . count($emails));

        file_put_contents('sent.json', json_encode($emails));

    }
}
