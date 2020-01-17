<?php

namespace App\Data;

use App\Address;
use App\Penpal;
use Carbon\Carbon;
use DB;

class Stats
{
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
}
