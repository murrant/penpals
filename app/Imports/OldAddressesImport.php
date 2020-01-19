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

class OldAddressesImport implements ToCollection, WithHeadingRow
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

        foreach ($rows as $index => $row) {
            $address = ucwords(strtolower($row['standardizedaddress']));
            if (Str::startsWith($address, 'Po Box')) {
                $address[1] = 'O';
            }

            $existing = Address::where('zip', $row['zipcode'])->where('address', 'like', $address)
                ->first();

            $now = Carbon::now()->subDays(30);
            if ($existing) {
                if (is_null($existing->completed)) {
                    $existing->assigned = $now;
                    $existing->completed = $now;
                    $existing->save();
                    $found++;
                    echo '$';
                } else {
                    $completed++;
                    echo '.';
                }
            }
        }

        echo "\nFound: $found  Done: $completed  Added: $added  Messy: $foundMessy\n";
    }
}
