<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home Page - PenPalsForYangHomepage</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: white;
        }

        .panel {
            padding: 25px;
        }
        .panel>p {
            margin-top: 20px;
        }
        .panel>h3 {
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="container">

    @if (false)
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">@lang('home')</a>
            @else
                <a href="{{ route('login') }}">@lang('Login')</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">@lang('Sign Up')</a>
                @endif
            @endauth
        </div>
    @endif


    <div class="row">
        <div class="col-12 flex-fill pad-5"
             style="padding:25px;width:100%;height:500px;background-image:url('{{ asset('images/penpalsforyang.jpeg') }}'); background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
    </div>
    <div class="row" style="margin-top: 30px">
        <h2>Volunteer Info</h2>
        <hr>
    </div>
    <div class="row">
        <div class="col-sm-4 justify-content-center text-center panel">
            <img src="{{ asset('images/1.png') }}">
            <h3>Become a Letter Writer</h3>
            <p>Become a Volunteer and we will set you up with a batch of new pen pals to write to</p>
            <div><a class="btn btn-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSf-4bqMYvMBFnOTJiVzP7C6-zmdGzdA_5cn5RcxH_jnmaMJ6w/viewform">SIGN UP</a></div>
        </div>
        <div class="col-sm-4 justify-content-center text-center panel">
            <img src="{{ asset('images/2.png') }}">
            <h3>Basic Letter Guidelines</h3>
            <p>Information and Basic Guidelines to follow for writing letters to your pen pal</p>
            <div class="justify-content-center"><a class="btn btn-primary" href="https://docs.google.com/document/d/1NGglZLKoOfeT4HjyQEBU_sbjkmBZNkLc12rKSPOIXeo/">FIND OUT MORE</a>
            </div>
        </div>
        <div class="col-sm-4 justify-content-center text-center panel">
            <img src="{{ asset('images/3.png') }}" class="round-circle">
            <h3>Black &amp; White Print Out</h3>
            <p>Click the Image for Fill In the Blank Or Download for Decorah Iowa</p>
            <div><a class="btn btn-primary" href="https://drive.google.com/file/d/1C8_KtU5ZoMynzEDn21gXRlqieiXn4jkH/view?usp=sharing">DOWNLOAD</a></div>
        </div>
    </div>
</div>

<footer class="border-top footer text-muted">
    <div class="container">
        © 2019 - PenPals For Yang - All Rights Reserved
    </div>
</footer>


</body>
</html>
