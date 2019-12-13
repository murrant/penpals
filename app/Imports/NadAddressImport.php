<?php

namespace App\Imports;

use App\Address;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class NadAddressImport implements ToModel, WithChunkReading, WithBatchInserts
{
    use Importable;

    private $zips;
    private $skipped = 0;
    private $currentRow;

    public function __construct(array $zips)
    {
        $this->zips = $zips;
    }

    /**
     * @param array $row
     *
     * @return Address|null
     */
    public function model(array $row)
    {
        $this->currentRow = $row;

        $city = '';
        foreach ([6, 4, 5, 3] as $field) {
            if (!empty($row[$field]) && $row[$field] !== 'UNINCORPORATED') {
                $city = $row[$field];
                break;
            }
        }
        if (!$city) {
            $this->skippedRow($row, $field);
            return null;
        }

        // skip not included zips
        if (!in_array($row[7], $this->zips)) {
            $this->skippedRow($row, 7);
            return null;
        }

        $address_number = implode(' ', array_filter(array_slice($row, 19, 3))); // 19-21
        $street = implode(' ', array_filter(array_slice($row, 11, 8))); // 11-18

        if (empty($address_number)) {
            $this->skippedRow($row, 20);
            return null;
        }
        if (!$row[15]) {
            $this->skippedRow($row, 15);
            return null;
        }

        $address = new Address([
            'address_number' => $address_number,
            'street' => ucwords(strtolower($street)),
            'building' => $row[24],
            'floor' => $row[25],
            'unit' => $row[26],
            'room' => $row[27],
            'additional' => $row[28],
            'city' => ucwords(strtolower($city)),
            'county' => $row[2],
            'state' => $row[1],
            'zip' => $row[7],
            'zip4' => $row[8],
        ]);

//        dd($address->toArray(), $row);

        return $address;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    public function getSkippedRows()
    {
        return $this->skipped;
    }

    public function getCurrentRow()
    {
        return $this->currentRow;
    }

    private function skippedRow(array $row, $field = null)
    {
        $this->skipped++;
        $message = 'skipped row';
        if ($field !== null) {
            $message .= ", invalid data in field $field: ({$row[$field]}) ";
        }
        echo $message . implode(',', $row) . PHP_EOL;
    }
}
