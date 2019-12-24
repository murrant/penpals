<?php

namespace App\Console\Commands;

use App\Address;
use App\AddressStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MelissaVerificationImport extends Command
{
    private $stats = [
        'valid' => 0,
        'invalid' => 0,
        'undeliverable' => 0,
        'skipped' => 0,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:melissaImport {file} {--offset=0} {--initial=}';

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
        $offset = $this->option('offset');
        $initial = $this->option('initial');
        $incrementingId = $initial;

        $results = json_decode(file_get_contents($file));

        foreach ($results as $validatedResult) {
            $id = $initial ? $incrementingId : ($validatedResult->Id - $offset);
            $address = Address::findOrFail($id);
            $incrementingId++;

            $zip = $validatedResult->PostalCode;
            $zip4 = $validatedResult->ZIP4;
            if (Str::contains($zip4, '-')) {
                list($zip, $zip4) = explode('-', $zip4);
            }

            $address->fill([
                'address' => $validatedResult->Address,
                'city' => $validatedResult->City,
                'state' => $validatedResult->State,
                'zip' => $zip,
                'zip4' => $zip4,
                'county' => $validatedResult->County,
                'status' => $this->checkResult($validatedResult),
                'mak' => $validatedResult->MAK,
            ]);
            $address->save();
        }

        foreach($this->stats as $stat => $count) {
            $this->info(ucfirst($stat) . ': ' . $count);
        }
        $total = count($results);
        $this->info("Result: " . $this->stats['valid'] . '/' . $total . ' (' . number_format($this->stats['valid']/$total*100, 2) . '%)' );

        exit(1);
    }

    /**
     * Get the status from the melissa address result code
     * http://wiki.melissadata.com/index.php?title=Result_Code_Details#Address_Object
     *
     * @param $result
     * @return int
     */
    private function checkResult($result): int
    {
        $codes = explode(',', $result->ResultCode);

        if (in_array('AS01', $codes)) {
            if (!empty(array_intersect($codes, ['AS02', 'AS03', 'AS16', 'AS17']))) {
                $this->error("Undeliverable valid address ($result->Address): $result->ResultDesc");
                $this->stats['undeliverable']++;
                return AddressStatus::Invalid;
            }

            $this->stats['valid']++;
            return AddressStatus::Valid;
        }

        if (Str::contains($result->ResultCode, 'AE')) {
            $this->error("Invalid address ($result->Address): $result->ResultDesc");
            $this->stats['invalid']++;
            return AddressStatus::Invalid;
        }

        $this->error("Skipped address ($result->Address): $result->ResultDesc");
        $this->stats['skipped']++;
        return AddressStatus::Unverified;
    }
}
