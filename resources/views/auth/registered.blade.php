@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Thank you for registering! You will receive an email with a login link shortly, which is the primary method for you to access your PenPals account.
                <br />
                <a href="{{ route('welcome') }}">Back to homepage</a>
            </div>
        </div>
    </div>
@endsection
