<?php

namespace App\Data;

use App\Address;
use App\AddressStatus;
use App\Penpal;
use Carbon\Carbon;
use DB;

class Stats
{
    private static $cacheTime = 60;

    public static function sentPerDay($days = 10)
    {
        return Address::where('completed', '>=', Carbon::now()->subDays($days))
            ->select(DB::raw('DATE_FORMAT(completed, "%Y-%m-%d") as day'), DB::raw('COUNT(*) as sent'))
            ->groupBy('day')->get();
    }

    public static function penpalsPerDay($days = 10)
    {
        return Penpal::where('created_at', '>=', Carbon::now()->subDays($days))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'), DB::raw('COUNT(*) as penpals'))
            ->groupBy('day')->get();
    }

    public static function unassignedAddresses()
    {
        return \Cache::remember('totalUnassignedValidAddresses', self::$cacheTime, function () {
            return Address::where('status', AddressStatus::Valid)
                ->whereNull('completed')
                ->where('penpal_id', 0)
                ->count();
        });
    }
}
