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
        $printColumns = 2;
        $penpal = Auth::user();
        $addresses = $penpal->addresses()->whereNull('completed')->get();

        return view('penpals', compact('penpal', 'addresses', 'printColumns'));
    }

    public function print()
    {
        $columns = 2;

        /** @var Penpal $penpal */
        $penpal = Auth::user();
        $addresses = $penpal->addresses()->whereNull('completed')->get()->chunk($columns);

        /** @var \Barryvdh\DomPDF\PDF $pdf */
        $pdf = PDF::loadView('pdf.penpals', compact('penpal', 'addresses'));
        return $pdf->stream('penpals.pdf');
    }
}
