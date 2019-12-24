<?php

namespace App\Console\Commands;

use App\Address;
use App\AddressStatus;
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
    protected $signature = 'address:melissaExport {--status=}';

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
        $status = (int)$this->option('status');
        $query = Address::query();
        if ($status !== null) {
            $query->where('status', AddressStatus::Pending);
        }

        $max = floor($query->count() / $this->batchSize);

        for ($batch = 0; $batch <= $max; $batch++) {
            $this->info("Exporting $batch of $max");

            $file = 'melissa/iowa_';
            if ($status !== null) {
                $file .= strtolower(AddressStatus::toString($status)) . '_';
            }
            $file .= $batch . '.csv';

            (new MelissaVerificationAddressExport($batch, $status))->store($file);
        }

        return 0;
    }
}
