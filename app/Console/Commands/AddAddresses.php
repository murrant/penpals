<?php

namespace App\Console\Commands;

use App\Data\VoteBuilder;
use App\Imports\OtherAddressImport;
use Excel;
use Illuminate\Console\Command;

class AddAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:import {file} {--other}';

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
        $file = $this->argument('file');
        if ($this->option('other')) {
            Excel::import(new OtherAddressImport(), $file);
        } else {
            $vb = new VoteBuilder($file);
            $vb->clean()
                ->load()
                ->import();
        }

        return 0;
    }
}
