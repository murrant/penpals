<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressStatus;
use App\Penpal;
use App\PenpalRole;
use Cache;
use Illuminate\Database\Query\Builder;

class FrontpageController extends Controller
{
    private $cacheTime = 300;
    private $topPenpals = 4;

    public function __invoke()
    {
        $data = [
            'completedAddresses' => $this->getCompletedAddresses(),
            'validAddresses' => $this->getValidAddresses() ?: 1,
            'totalPenpals' => $this->getTotalPenpals(),
            'topFive' => $this->getTopFive(),
        ];

        return view('frontpage', $data);
    }

    private function getCompletedAddresses()
    {
        return Cache::remember('frontpage:completedAddresses', $this->cacheTime, function () {
            return Address::query()->whereNotNull('completed')->count();
        });
    }

    private function getValidAddresses()
    {
        return Cache::remember('frontpage:validAddresses', $this->cacheTime, function () {
            return Address::query()->where('status', AddressStatus::Valid)->count();
        });
    }

    private function getTotalPenpals()
    {
        return Cache::remember('frontpage:totalPenpals', $this->cacheTime, function () {
            return Penpal::where('role', PenpalRole::Writer)->count();
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
                ->limit($this->topPenpals)
                ->get()
                ->pluck('addresses_count', 'first_name')
                ->toArray();
        });
    }

}
