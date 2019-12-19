<?php

namespace App\Http\Controllers;

use App\AddressRequest;
use Illuminate\Http\Request;
use Storage;

class AddressRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('address-request');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('address-request');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'proof' => 'required|image',
            'amount' => 'required|integer',
            'note' => 'required|string'
        ]);

        if ($request->user()->addressRequests()->count() > 0) {
            return redirect()->back()
                ->withErrors(['error' => 'You already have a pending request.'])
                ->withInput($request->input());
        }

        $file = $request->file('proof')->store('requests');

        if ($file === false) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors(['proof' => 'Failed to upload image']);
        }

        $data = $request->only(['amount', 'note']);
        $data['image'] = $file;

        $request->user()->addressRequests()->save(new AddressRequest($data));

        return view('address-request-sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
