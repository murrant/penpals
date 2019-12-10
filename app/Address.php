<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function scopeIsUnassigned($query) {
        return $query->where('penpal_id', 0);
    }

    public function scopeRandomAllotment($query)
    {
        return $query
            ->where('penpal_id', 0)
            ->inRandomOrder()
            ->limit(config('penpals.initial-addresses', 5));
    }

    public function penpal()
    {
        return $this->hasOne(\App\Penpal::class, 'id', 'penpal_id');
    }
}
