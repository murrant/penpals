<?php

namespace App\Console\Commands;

use App\Imports\NadAddressImport;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Symfony\Component\Process\Process;

class NadImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nad:import {zipcodes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import form NAD with comma separated zips';

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
        $file = 'data/NAD_r3.txt';
        $zipcodes = preg_replace('[^0-9,]', '', $this->argument('zipcodes'));
        $tempFile = 'data/' . md5($zipcodes) . '.csv';
        $zips = explode(',', $zipcodes);

        if (!file_exists($tempFile)) {
            $grepContent = ',' . implode(',|,', $zips) . ',';
            $process = Process::fromShellCommandline("egrep '$grepContent' $file > $tempFile");
            $process->run();
        }

        $import = new NadAddressImport($zips);
        try {
            $import->import($tempFile);
        } catch (QueryException $qe) {
            $this->error($qe->getMessage());
            $this->error(implode(',', $import->getCurrentRow()));
            return 1;
        }

        $this->info("Skipped " . $import->getSkippedRows() . " rows.");

        return 0;
    }
}
