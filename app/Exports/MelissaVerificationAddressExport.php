<?php

namespace App\Exports;

use App\Address;
use App\AddressStatus;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MelissaVerificationAddressExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    private $batch;

    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $offset = ($this->batch) * 500;

        $query = Address::query()->limit(500)->offset($offset);
//            ->where('status', AddressStatus::Unverified);
        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Address',
            'Address 2',
            'zip'
        ];
    }

    /**
     * @param Address $address
     *
     * @return array
     */
    public function map($address): array
    {
        return [
            $address->id,
            $address->addressLineOne(),
            implode(' ', $address->addressLineTwo()),
            $address->zip,
        ];
    }
}
