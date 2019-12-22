<?php

namespace App;

use App\Exceptions\MaxAddresses;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\Factory as Queue;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Mail;

class Penpal extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['email', 'first_name', 'last_name', 'phone', 'role', 'address'];
    protected $appends = ['name'];

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

    public function sendLoginEmail($remember = false, $view = 'auth.emails.email-login')
    {
        $url = $this->buildLoginLink($remember);

        Mail::send('auth.emails.email-login', ['url' => $url], function ($m) {
            /** @var Mailable $m */
            $m->to($this->email, $this->name)->subject('PenPals for Yang Login');
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
