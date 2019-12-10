<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Address extends Model
{
    protected $fillable = [
        'house_number',
        'street',
        'street_suffix',
        'city',
        'state',
        'zip',
        'street_name',
        'address',
        'state_name',
        'zip4',
        'address_type',
        'rbdi',
        'fips',
        'county',
        'result_code',
        'mak',
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
