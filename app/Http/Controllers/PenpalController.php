<?php

namespace App\Http\Controllers;

use App\Penpal;
use Auth;
use PDF;

class PenpalController extends Controller
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
        return view('penpals', ['penpal' => Auth::user()]);
    }
}
