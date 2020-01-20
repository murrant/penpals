<?php

namespace App\Http\Controllers;

use App\Address;
use App\Penpal;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var Penpal $penpal */
        $penpal = Auth::user();

        $penpal->load(['addresses.residents' => function ($query) {
            /** @var Builder $query */
            $query->select(['id', 'address_id', 'name', 'age_range', 'gender', 'relation']);
        }]);

        if (\request('partition')) {
            [$assigned, $completed] = $penpal->addresses->partition(function ($address) {
                return $address->completed == null;
            });
            return response()->json(compact('assigned', 'completed'));
        }

        return response()->json(['addresses' => $penpal->addresses]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Address::with('addresses.residents')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'completed' => 'required|boolean'
        ]);

        $address = Address::findOrFail($id);
        $address->completed = $request->get('completed') ? Carbon::now() : null;
        $address->save();

        return response()->json($address);
    }
}
