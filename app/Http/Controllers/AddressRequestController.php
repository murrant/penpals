<?php

namespace App\Http\Controllers;

use App\AddressRequest;
use App\Events\AddressRequestApproved;
use Illuminate\Http\Request;
use Storage;

class AddressRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('approve-requests');

        return view('address-request-list')->with([
            'requests' => AddressRequest::with('penpal')->get(),
        ]);
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
     * @param \Illuminate\Http\Request $request
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
     * Approve request
     *
     * @param Request $request
     * @param AddressRequest $addressRequest
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function approve(Request $request, AddressRequest $addressRequest)
    {
        $this->authorize('approve-requests');
        $this->validate($request, [
            'amount' => 'required|integer',
            'message' => 'nullable|string',
        ]);
        $addressRequest->amount = $request->get('amount');

        event(new AddressRequestApproved($addressRequest, $addressRequest->penpal, $request->get('message')));

        return response()->json([]);
    }

    /**
     * Deny request
     *
     * @param Request $request
     * @param AddressRequest $addressRequest
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deny(Request $request, AddressRequest $addressRequest)
    {
        $this->authorize('approve-requests');
        $this->validate($request, [
            'amount' => 'required|integer',
            'message' => 'required|string',
        ]);
        $addressRequest->amount = $request->get('amount');

        event(new AddressRequestApproved($addressRequest, $addressRequest->penpal, $request->get('message')));

        return response()->json([]);
    }
}
