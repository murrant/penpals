@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Login email sent to {{ $email }}
                <br />
                You can close this window and click the login link from your email.
            </div>
        </div>
    </div>
@endsection
