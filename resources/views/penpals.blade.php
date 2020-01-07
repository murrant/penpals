@extends('layouts.app')

@section('content')
    <div class="non-printable">
        <address-list addresses="{{ $addresses }}"></address-list>
    </div>

    <div class="printable">
        @include('printables.penpals')
    </div>
@endsection
