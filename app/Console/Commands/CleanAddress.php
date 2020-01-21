<?php

namespace App\Console\Commands;

use App\Address;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CleanAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:address {--city=}';

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
        Address::when($this->option('city'), function ($q) { $q->where('city', $this->option('city')); })
            ->chunk(100, function ($addresses) {
            foreach ($addresses as $address) {
                $new = [];
                /** @var Address $address */
                if (empty($address->address)) {
                    $new[] = $address->address_number;
                    $new[] = $address->street;
                    if ($address->building) {
                        $new[] = Str::contains($address->building, ' ') ? $address->building : "Bldg $address->building";
                    }
                    if ($address->floor) {
                        $new[] = Str::contains($address->floor, ' ') ? $address->floor : "Fl $address->floor";
                    }
                    if ($address->unit) {
                        $new[] = Str::contains($address->unit, ' ') ? $address->unit : "Unit $address->unit";
                    }
                    if ($address->room) {
                        $new[] = Str::contains($address->room, ' ') ? $address->room : "Rm $address->room";
                    }
                    if ($address->additional) {
                        $new[] = $address->additional;
                    }
                    $address->address = implode(' ', $new);
                }

                $address->address = $this->rewrite($address->address);
                if ($address->isDirty('address')) {
                    echo "\"{$address->getOriginal('address')}\" > \"$address->address\"\n";
                }
                $address->save();
            }
        });


        return 0;
    }

    private function rewrite($address)
    {
        $address = str_replace([
            ' Street',
            ' Road',
            ' Avenue',
            ' Circle',
            ' Alley',
            ' Boulevard',
            ' Drive',
            ' Lane',
            ' Place',
            ' Court',
        ], [
            ' St',
            ' Rd',
            ' Ave',
            ' Cir',
            ' Aly',
            ' Blvd',
            ' Dr',
            ' Ln',
            ' Pl',
            ' Ct',
        ], $address);

        $address = str_replace([
            ' Floor ',
            ' Room ',
            ' Building ',
        ], [
            ' Fl ',
            ' Rm ',
            ' Bldg ',
        ], $address);

        $address = preg_replace([
            '/North$/i',
            '/Northeast$/i',
            '/Northwest$/i',
            '/East$/i',
            '/South$/i',
            '/Southeast$/i',
            '/Southwest$/i',
            '/West$/i',
        ], [
            'N',
            'NE',
            'NW',
            'E',
            'S',
            'SE',
            'SW',
            'W',
        ], $address);

        return $address;
    }
}
