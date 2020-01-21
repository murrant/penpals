@extends('layouts.app')

@section('content')
    <div class="container">
        @if($available < 100)
            <div class="row">
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header bg-danger text-light">
                            <strong>Warning! Available addresses running low!</strong>
                        </div>
                        <div class="card-body">
                            {{ $available }} addresses left
                        </div>
                    </div>

                </div>
            </div>
        @endif

        <div class="row">
            <div class="col">
                @forelse($requests as $request)
                    <address-request :penpal="{{ $request->penpal }}"
                                     :previous="{{ json_encode(Arr::wrap($images->get($request->penpal_id))) }}"
                                     :request="{{ $request }}"
                                     :sent="{{ $sent->get($request->penpal_id, 0) }}"
                                     :available="{{ $available }}"
                    ></address-request>
                @empty
                    No current requests :)
                @endforelse
            </div>
        </div>
    </div>
@endsection
