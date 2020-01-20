<?php

namespace App\Console\Commands;

use App\Data\VoteBuilder;
use Illuminate\Console\Command;

class AddAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:import {file}';

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
        $vb = new VoteBuilder($this->argument('file'));
        $vb->clean()
            ->load()
            ->import();

        return 0;
    }
}
