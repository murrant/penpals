<?php

namespace App\Console\Commands;

use App\Imports\AddressImport;
use App\Imports\UsedAddressesImport;
use Excel;
use Illuminate\Console\Command;

class ImportUsedAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:importUsed {file}';

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
        $file = $this->argument('file');
        Excel::import(new UsedAddressesImport(), $file);

        return 0;
    }
}
