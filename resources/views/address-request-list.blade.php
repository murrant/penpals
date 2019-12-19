@extends('layouts.app')

@section('content')
<div class="container">
    @forelse($requests as $request)
        <address-request :request="{{ $request }}" :penpal="{{ $request->penpal }}"></address-request>
    @empty
        No current requests :)
    @endforelse
@endsection
