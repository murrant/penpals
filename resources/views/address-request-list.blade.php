@extends('layouts.app')

@section('content')
<div class="container">
    @forelse($requests as $request)
        <address-request :penpal="{{ $request->penpal }}"
                         :previous="{{ json_encode(Arr::wrap($images->get($request->penpal_id))) }}"
                         :request="{{ $request }}"
                         :sent="{{ $sent->get($request->penpal_id) }}"
        ></address-request>
    @empty
        No current requests :)
    @endforelse
</div>
@endsection
