<?php

namespace App\Imports;

use App\Address;
use App\AddressStatus;
use App\Resident;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OtherAddressImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $skipped = 0;
    private $currentRow;

    /**
     * @param array $row
     *
     * @return Address|null
     */
    public function model(array $row)
    {
        $address = Address::firstOrCreate([
            'address' => $row['standardizedaddress'],
            'zip' => $row['zipcode'],
        ],[
            'status' => AddressStatus::Valid,
            'address' => $row['standardizedaddress'],
            'city' => $row['city'],
            'state' => $row['state'],
            'zip' => $row['zipcode'],
            'zip4' => $row['zipfour'],
            'address_number' => '',
            'street' => '',
            'county' => '',
        ]);

        $address->residents()->save(new Resident([
            'name' => $row['full_name'],
            'first_name' => $row['firstname'],
            'last_name' => $row['lastname'],
            'age_range' => $row['age'],
        ]));

        return $address;
    }
}
