<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Home
    </title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gredients/purple.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography/poppins-quciksland.css') }}">

</head>

<body data-spy="scroll" data-target="#navbarCodeply" data-offset="70">
    @include('client.partials.navbar')
    @yield('content')
    @include('client.partials.footer')
</body>

<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.textillate.js') }}"></script>
<script src="{{ asset('js/jquery.lettering.js') }}"></script>
<script src="{{ asset('js/jquery.fittext.js') }}"></script>
<script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/swiper.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>


</html>
