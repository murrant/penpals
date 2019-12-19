<?php

namespace App\Console\Commands;

use App\Address;
use App\Imports\AddressImport;
use DB;
use Illuminate\Console\Command;
use Excel;

class ImportAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:addresses {file} {--json}';

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
        if ($this->option('json')) {
            DB::unprepared('SET IDENTITY_INSERT addresses ON');
            $data = json_decode(file_get_contents($file), true);
            foreach (array_chunk($data, 50) as $addressChunk) {
                Address::insert($addressChunk);
            }
            DB::unprepared('SET IDENTITY_INSERT addresses OFF');
        } else {
            Excel::import(new AddressImport, $file);
        }

        return 0;
    }
}
