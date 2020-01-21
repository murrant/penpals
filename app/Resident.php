<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'age_range',
        'gender',
        'relation',
    ];
}
