<?php

namespace App\Exports;

use App\Address;
use App\AddressStatus;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MelissaVerificationAddressExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    private $batch;

    public function __construct($batch)
    {
        $this->batch = $batch;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $offset = ($this->batch) * 500;

        return Address::query()
            ->limit(500)
            ->offset($offset)
//            ->where('status', AddressStatus::Unverified)
            ->orderBy('id')
            ->get();
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
