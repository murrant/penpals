<?php

namespace App\Imports;

use App\Penpal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Propaganistas\LaravelPhone\PhoneNumber;

class PenpalImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        if (Penpal::query()->where('email', $row['username'])->exists()) {
            return null;
        }

        $penpal =  new Penpal([
            'email' => $row['username'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'phone' => PhoneNumber::isValidFormat($row['phone_number']) ? PhoneNumber::make($row['phone_number'])->formatE164() : $row['phone_number'],
            'address' => $row['mailing_address'],
            'role' => 0,
        ]);

        $penpal->created_at = Carbon::parse($row['timestamp']);

        return $penpal;
    }
}
