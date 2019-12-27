<?php

namespace App\Console\Commands;

use App\Imports\PenpalImport;
use Excel;
use Illuminate\Console\Command;

class ImportPenpals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'penpals:import {file}';

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
        Excel::import(new PenpalImport(), $file);

        return 0;
    }
}
