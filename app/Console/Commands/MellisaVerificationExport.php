<?php

namespace App\Console\Commands;

use App\Address;
use App\Exports\MelissaVerificationAddressExport;
use Illuminate\Console\Command;

class MellisaVerificationExport extends Command
{
    private $batchSize = 499;

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
        $max = floor(Address::count() / $this->batchSize);

        for ($batch = 0; $batch <= $max; $batch++) {
            $this->info("Exporting $batch of $max");
            $file = 'melissa/iowa_' . $batch . '.csv';
            (new MelissaVerificationAddressExport($batch))->store($file);
        }

        return 0;
    }
}
