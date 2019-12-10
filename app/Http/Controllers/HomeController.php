<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $penpal = Auth::user();

        $penpal->load(['addresses.residents' => function ($query) {
            $query->where('relation', 'Primary');
        }]);

        [$assigned, $completed] = $penpal->addresses->partition(function ($address) {
            return $address->mailed == null;
        });

//        dd($penpal->addresses->toArray());

        return view('home', [
            'penpal' => $penpal,
            'assigned' => $assigned,
            'completed' => $completed,
        ]);
    }
}
