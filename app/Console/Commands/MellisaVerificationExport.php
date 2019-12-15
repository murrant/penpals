<?php

namespace App\Console\Commands;

use App\Address;
use App\Exports\MelissaVerificationAddressExport;
use Illuminate\Console\Command;

class MellisaVerificationExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:melissaExport';

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
        $max = ceil(Address::count() / 500);
        $batch = 0;

        for ($batch = 0; $batch <= $max; $batch++) {
            $this->info("Exporting $batch of $max");
            $file = base_path('data/iowa_' . $batch . '.csv');
            (new MelissaVerificationAddressExport($batch))->store($file);
        }

        return 0;
    }
}
