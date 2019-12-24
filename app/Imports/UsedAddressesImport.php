<?php

namespace App\Imports;

use App\Address;
use App\AddressStatus;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsedAddressesImport implements ToCollection, WithHeadingRow
{
    use Importable;


    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $found = 0;
        $foundMessy = 0;
        $completed = 0;
        $added = 0;
        // HouseNumber,Street,StreetSuffix,City,State,Zip,StreetName,Address,StateName,Zip4,AddressType,RBDI,Fips,County,ResultCode,MAK
        foreach ($rows as $row) {
            $number = $row['housenumber'];
            $unit = '';
            if (Str::contains($number, ' ')) {
                list($number, $unit) = explode(' ', $number, 2);
            }


            $existing = Address::where('mak', 'like', $row['mak'])
                ->first();

            if (!$existing) {
                $existing = Address::where(function ($query) use ($row, $number, $unit) {
                    /** @var Builder $query */
                    $query->where('address_number', $number)
                        ->where('unit', 'like', $unit)
                        ->where('street', 'like', ($row['streetname'] ?: $row['street']) . '%')
                        ->where('zip', $row['zip']);
                })->first();
                if ($existing) {
                    $foundMessy++;
                    echo '~';
                }
            }

            $now = Carbon::now();
            if ($existing) {
                if (is_null($existing->completed)) {
                    $existing->address_type = $existing->address_type ?: $row['rbdi'];
                    $existing->assigned = $now;
                    $existing->completed = $now;
                    $existing->save();
                    $found++;
                    echo '$';
                } else {
                    $completed++;
                    echo '.';
                }
            } else {
                Address::create([
                    'mak' => $row['mak'],
                    'status' => AddressStatus::Pending,
                    'address' => $row['address'],
                    'address_number' => $number,
                    'unit' => $unit,
                    'street' => ucwords(strtolower($row['streetname'] ?: ($row['street'] . ' ' . $row['streetsuffix']))),
                    'city' => ucwords(strtolower($row['city'])),
                    'county' => ucwords(strtolower($row['county'])),
                    'state' => $row['state'],
                    'zip' => $row['zip'],
                    'zip4' => $row['zip4'],
                    'address_type' => $row['rbdi'],
                    'assigned' => $now,
                    'completed' => $now,
                ]);
                $added++;
                echo '+';

//                echo 'Address not found! ' . $row->implode(',') . PHP_EOL;
            }
        }

        echo "\nFound: $found  Done: $completed  Added: $added  Messy: $foundMessy\n";
    }
}
