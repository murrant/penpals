<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmailLogin extends Model
{
    public $fillable = ['email', 'token'];

    public static function createForEmail($email)
    {
        return self::create([
            'email' => $email,
            'token' => Str::random(20)
        ]);
    }

    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-15 minutes'))
            ->firstOrFail();
    }

    public function penpal()
    {
        return $this->hasOne(\App\Penpal::class, 'email', 'email');
    }
}
