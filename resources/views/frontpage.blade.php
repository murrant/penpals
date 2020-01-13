@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10 col-xs-12 logo">
            <img class="img-fluid" src="{{ asset('images/penpalsforyang.jpeg') }}">
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-3 col-xs-4 mt-4 text-center">
                <h3>@lang('Penpals')</h3>
                <div class="display-4">{{ $totalPenpals }}</div>
            </div>
            <div class="col-sm-3 col-xs-4 mt-4 text-center">
                <h3>@lang('Letters Sent')</h3>
                <div class="display-4">
                    {{ number_format($completedAddresses / $validAddresses * 100, 0) }}%
                </div>
                <h4><strong>{{ $completedAddresses }} / {{ $validAddresses }}</strong></h4>
            </div>
            <div class="col-sm-3 col-xs-4 mt-4 text-center">
                <h3>@lang('Top Penpals')</h3>

                @foreach($topFive as $name => $count)
                    <div class="row">
                        <div class="col text-right"><strong>{{ $count }}</strong></div>
                        <div class="col text-left"><strong>{{ $name }}</strong></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row mt-4 ml-3">
            <h2>@lang('Volunteer Info')</h2>
        </div>
        <div class="col">
            <hr>
        </div>
        <div class="row row-eq-height">
            <div class="col-sm-12 col-md-6 col-lg-4 text-center panel mt-2">
                <img class="img-fluid" src="{{ asset('images/mail.png') }}">
                <h3>Become a Letter Writer</h3>
                <p>Become a Volunteer and we will set you up with a batch of new pen pals to write to</p>
                <div><a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a></div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 text-center panel mt-2">
                <img class="img-fluid" src="{{ asset('images/writing.png') }}">
                <h3>Basic Letter Guidelines</h3>
                <p>Information and Basic Guidelines to follow for writing letters to your pen pal</p>
                <div class="justify-content-center"><a class="btn btn-primary" href="{{ route('welcome') }}/">FIND OUT MORE</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 text-center panel d-flex flex-column mt-2">
                <div class="flex-grow-1 d-flex">
                    <div class="embed-responsive embed-responsive-16by9 align-self-center">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/uG5I-32sG20" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div>
                    <h3>Training Video</h3>
                    <p>This video will go through everything you need to be able be successful</p>
                    <div><a class="btn btn-primary" href="https://drive.google.com/file/d/1C8_KtU5ZoMynzEDn21gXRlqieiXn4jkH/view?usp=sharing">DOWNLOAD</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
