<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressStatus;
use App\Penpal;
use Cache;
use Illuminate\Database\Query\Builder;

class FrontpageController extends Controller
{
    private $cacheTime = 300;

    public function __invoke()
    {
        $data = [
            'totalSent' => $this->getTotalSent(),
            'totalPenpals' => $this->getTotalPenpals(),
            'topFive' => $this->getTopFive(),
        ];

        return view('frontpage', $data);
    }

    private function getTotalSent()
    {
        return Cache::remember('frontpage:totalSent', $this->cacheTime, function () {
            $completed = Address::query()->whereNotNull('completed')->count();
            $valid = Address::query()->where('status', AddressStatus::Valid)->count();
           return number_format($completed / $valid * 100, 0);
        });
    }

    private function getTotalPenpals()
    {
        return Cache::remember('frontpage:totalPenpals', $this->cacheTime, function () {
            return Penpal::count();
        });
    }

    private function getTopFive()
    {
        return Cache::remember('frontpage:topFive', $this->cacheTime, function () {
            return Penpal::withCount(['addresses' => function ($query) {
                /** @var Builder $query */
                return $query->whereNotNull('completed');
            }])
                ->orderBy('addresses_count', 'desc')
                ->limit(3)
                ->get()
                ->pluck('addresses_count', 'first_name')
                ->toArray();
        });
    }

}
