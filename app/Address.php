<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Address extends Model
{
    protected $fillable = [
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

        $address[] = str_replace('  ', ' ', "$this->address_number $this->unit $this->street");

        $added = array_filter([
            $this->building,
            $this->floor,
            $this->room,
            $this->additional,
        ]);

        if ($added) {
            $address[] = implode(' ', $added);
        }

        $address[] = "$this->city, $this->state $this->zip" . ($this->zip4 ? "-$this->zip4" : '');

        return implode($separator, $address);
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
    public function scopeRandomAllotment($query)
    {
        return $query
            ->where('penpal_id', 0)
            ->inRandomOrder()
            ->limit(config('penpals.addresses.allotment', 5));
    }

    public function penpal()
    {
        return $this->belongsTo(\App\Penpal::class, 'id', 'penpal_id');
    }

    public function residents()
    {
        return $this->hasMany(\App\Resident::class, 'address_id', 'id');
    }
}
