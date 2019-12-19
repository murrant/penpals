<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'amount',
        'note'
    ];

    public function penpal()
    {
        return $this->belongsTo(Penpal::class, 'penpal_id', 'id');
    }
}
