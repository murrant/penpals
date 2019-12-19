@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($requests as $request)
        <address-request :request="{{ $request }}" :penpal="{{ $request->penpal }}"></address-request>
    @endforeach
</div>
@endsection
