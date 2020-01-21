<?php

namespace App;

class AddressStatus
{
    const Unverified = 0;
    const Pending = 1;
    const Invalid = 2;
    const Valid = 3;

    public static function toString(int $status)
    {
        return collect([
            0 => 'Unverified',
            1 => 'Pending',
            2 => 'Invalid',
            3 => 'Valid',
            4 => 'Expired',
        ])->get($status, 'Error Status not found');
    }
}
