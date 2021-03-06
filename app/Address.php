<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Address extends Model
{
    protected $fillable = [
        'mak',
        'status',
        'address',
        'address_number',
        'street',
        'building',
        'floor',
        'unit',
        'room',
        'additional',
        'city',
        'county',
        'state',
        'zip',
        'zip4',
        'address_type',
        'assigned',
        'completed',
    ];

    public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        Address::saving(function($address)
        {
            /** @var Address $address */
            if ($address->penpal_id && $address->getOriginal('penpal_id') == 0) {
                // if a penpal was just assigned
                $address->assigned = Carbon::now();
            }
        });
    }

    public function toString($separator = "\n")
    {
        $address = [];

        $address[] = $this->addressLineOne();
        $added = $this->addressLineTwo();

        if ($added) {
            $address[] = implode(' ', $added);
        }

        $address[] = $this->addressLineThree();

        return implode($separator, $address);
    }

    public function addressLineOne()
    {
        return str_replace('  ', ' ', "$this->address_number $this->unit $this->street");
    }

    public function addressLineTwo()
    {
        return array_filter([
            $this->building,
            $this->floor,
            $this->room,
            $this->additional,
        ]);
    }

    public function addressLineThree()
    {
        return "$this->city, $this->state $this->zip" . ($this->zip4 ? "-$this->zip4" : '');
    }


    /**
     * Select only unassigned addresses
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsUnassigned($query) {
        return $query->where('penpal_id', 0);
    }

    /**
     * select x random unassigned addresses
     * @param Builder $query
     * @return Builder
     */
    public function scopeRandomAllotment($query, $amount)
    {
        return $query
            ->where('penpal_id', 0)
            ->where('status', AddressStatus::Valid)
            ->whereNull('completed')
            ->inRandomOrder()
            ->limit($amount ?? config('penpals.addresses.allotment', 5));
    }

    public function penpal()
    {
        return $this->belongsTo(\App\Penpal::class, 'penpal_id', 'id');
    }

    public function residents()
    {
        return $this->hasMany(\App\Resident::class, 'address_id', 'id');
    }
}
