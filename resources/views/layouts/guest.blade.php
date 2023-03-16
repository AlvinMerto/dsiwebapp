<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> DSI Webapp </title>

        <!-- Fonts -->
        <!--link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@100;300&display=swap" rel="stylesheet">

            <!-- vendor css -->
            <link href="{{ asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
            <link href="{{ asset('lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
            
            <!-- Bracket CSS -->
            <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">

        <!-- Scripts -->
       
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="d-flex align-items-center justify-content-center ht-100v" style="background-image: url('https://webapp.dimensionsystems.com/assets/media//bg/bg-3.jpg')">
            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">
                <img src="{{ asset('images/DimensionSystems-logo-r1.png') }}" class="w-100 fill-current text-gray-500" />
            </div>
            <div class="tx-center mg-b-60"> Sign in to start your session </div>
                {{$slot}}
                <!--div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Enter your password">
                    <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-info btn-block">Sign In</button-->

            <!--div class="mg-t-60 tx-center">Not yet a member? <a href="/register" class="tx-info">Sign Up</a></div-->
            </div><!-- login-wrapper -->
        </div><!-- d-flex -->
    </body>
</html>
