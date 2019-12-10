<?php

namespace App\Imports;

use App\Address;
use Maatwebsite\Excel\Concerns\ToModel;

class AddressImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Address|null
     */
    public function model(array $row)
    {
        return new Address([
            'house_number' => $row[0],
            'street'    => $row[1],
            'street_suffix' => $row[2],
            'city' => $row[3],
            'state' => $row[4],
            'zip' => $row[5],
            'street_name' => $row[6],
            'address' => $row[7],
            'state_name' => $row[8],
            'zip4' => $row[9],
            'address_type' => $row[10],
            'rbdi' => $row[11],
            'fips' => $row[12],
            'county' => $row[13],
            'result_code' => $row[14],
            'mak' => $row[15],
        ]);
    }
}
