@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 logo">
            <img class="img-fluid" src="{{ asset('images/penpalsforyang.jpeg') }}">
        </div>
    </div>
    <div class="container">
        <div class="row mt-4">
            <h2>Volunteer Info</h2>
        </div>
        <div class="col"><hr></div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 justify-content-center text-center panel">
                <img src="{{ asset('images/mail.png') }}">
                <h3>Become a Letter Writer</h3>
                <p>Become a Volunteer and we will set you up with a batch of new pen pals to write to</p>
                <div><a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a></div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 justify-content-center text-center panel">
                <img src="{{ asset('images/writing.png') }}">
                <h3>Basic Letter Guidelines</h3>
                <p>Information and Basic Guidelines to follow for writing letters to your pen pal</p>
                <div class="justify-content-center"><a class="btn btn-primary" href="{{ route('welcome') }}/">FIND OUT MORE</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 justify-content-center text-center panel">
                <img src="{{ asset('images/flyer_bw.png') }}" class="round-circle">
                <h3>Black &amp; White Print Out</h3>
                <p>Click the Image for Fill In the Blank Or Download for Decorah Iowa</p>
                <div><a class="btn btn-primary" href="https://drive.google.com/file/d/1C8_KtU5ZoMynzEDn21gXRlqieiXn4jkH/view?usp=sharing">DOWNLOAD</a></div>
            </div>
        </div>
    </div>
@endsection
