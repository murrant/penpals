@extends('layouts.app')

@section('content')
    <div>
        <address-list name="{{ $penpal->name }}"></address-list>
    </div>
@endsection
