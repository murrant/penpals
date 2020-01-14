<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressRequest;
use App\Events\AddressRequestApproved;
use DB;
use Illuminate\Http\Request;

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

        $requests = AddressRequest::with('penpal')->get();

        $penpalIds = $requests->pluck('penpal_id')->unique();

        $sent = Address::whereIn('penpal_id', $penpalIds)
            ->select('penpal_id', DB::raw('count(*) as total'))
            ->groupBy(['penpal_id'])->pluck('total', 'penpal_id');

        $previous = AddressRequest::onlyTrashed()->whereIn('penpal_id', $penpalIds)
            ->select('penpal_id', 'image')->get()->groupBy('penpal_id')->map->pluck('image');

        return view('address-request-list')->with([
            'requests' => $requests,
            'sent' => $sent,
            'images' => $previous,
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
