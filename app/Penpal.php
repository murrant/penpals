<?php

namespace App;

use App\Exceptions\MaxAddresses;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Mail;

class Penpal extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['email', 'first_name', 'last_name', 'phone', 'role', 'address'];
    protected $appends = ['name'];
    protected $hidden = ['remember_token'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

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

        // lock addresses so they aren't double assigned.
//        $locks = collect();
        $addresses = Address::query()->randomAllotment($amount)->get()->map(function ($adddress) {
            $adddress->assigned = Carbon::now();
            return $adddress;
        });
//        ->filter(function ($address) use ($locks) {
//            $lock = Cache::lock('address_assign_' . $address->id, 10);
//            if ($lock->get()) {
//                $locks->push($lock);
//                return true;
//            }
//
//            return false;
//        });

        $this->addresses()->saveMany($addresses);

//        $locks->each->release();

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

    public function sendLoginEmail($remember = false, $view = 'auth.emails.email-login', $subject = 'PenPals for Yang Login')
    {
        $url = $this->buildLoginLink($remember);

        Mail::send($view, ['url' => $url], function ($m) use ($subject) {
            /** @var Mailable $m */
            $m->to($this->email, $this->name)->subject($subject);
        });
    }

    private function buildLoginLink($remember)
    {
        $emailLogin = EmailLogin::createForEmail($this->email);

        $params = ['token' => $emailLogin->token];
        if ($remember) {
            $params['remember'] = 'remember';
        }

        return route('auth.email-authenticate', $params);
    }
}
