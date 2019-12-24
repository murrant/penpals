<?php

namespace App\Exports;

use App\Address;
use App\AddressStatus;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MelissaVerificationAddressExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    private $batch;
    private $status;

    public function __construct($batch, $status = null)
    {
        $this->batch = $batch;
        $this->status = $status;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $offset = ($this->batch) * 499;

        $query = Address::query()
            ->limit(499)
            ->offset($offset)
            ->orderBy('id');
        if ($this->status !== null) {
            $query->where('status', AddressStatus::Pending);
        }

        return $query->get();
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
