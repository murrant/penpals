<?php

namespace App;

use App\Exceptions\MaxAddresses;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penpal extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['email', 'first_name', 'last_name', 'phone', 'role', 'address'];

    /**
     * Request and assign additional allotment of addresses
     * @param int|null $amount
     * @return Address[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws MaxAddresses
     */
    public function assignAddressAllotment($amount = null)
    {
        if ($this->addresses()->count() >= config('penpals.addresses.max')) {
            throw new MaxAddresses();
        }

        $addresses = Address::query()->randomAllotment($amount)->get();
        // TODO lock addresses before assigning
        $this->addresses()->saveMany($addresses);
        return $addresses;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'penpal_id', 'id');
    }

    public function addressRequests()
    {
        return $this->hasMany(AddressRequest::class, 'penpal_id', 'id');
    }
}
