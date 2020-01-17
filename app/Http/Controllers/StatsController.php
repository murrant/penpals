<?php

namespace App\Http\Controllers;

use App\Data\Stats;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __invoke(Request $request)
    {
        $days = $request->get('days', 14);

        return view('stats', [
            'days' => $days,
            'perDay' => $this->perDay($days),
        ]);
    }


    private function perDay($days)
    {
        $penpalsPerDay = Stats::penpalsPerDay($days)->pluck('penpals', 'day');
        $sentPerDay = Stats::sentPerDay($days)->pluck('sent', 'day');

        return $penpalsPerDay->keys()->merge($sentPerDay->keys())
            ->unique()->sort(function ($a, $b) {
                return Carbon::parse($a)->lt(Carbon::parse($b));
            })->map(function ($key) use ($penpalsPerDay, $sentPerDay) {
                return [
                    'day' => $key,
                    'penpals' => $penpalsPerDay->get($key, 0),
                    'sent' => $sentPerDay->get($key, 0),
                ];
            })->sort();
    }
}
