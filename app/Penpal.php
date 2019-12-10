<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penpal extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['email', 'first_name', 'last_name', 'phone', 'role', 'address'];


    public function addresses()
    {
        return $this->hasMany(\App\Address::class, 'penpal_id', 'id');
    }
}
