<?php

namespace App\Console\Commands;

use App\Address;
use Illuminate\Console\Command;

class ExportAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:export {file} {--json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        if ($this->option('json')) {
            file_put_contents($this->argument('file'), json_encode(Address::all()));
        }

        return 0;
    }
}
