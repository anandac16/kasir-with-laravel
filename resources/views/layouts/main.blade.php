<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <title>@yield('title')</title>
</head>

<body>
    @yield('content')
 <!-- Argon Scripts -->
 <!-- Core -->
 <script src="{{ URL::asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
 <script src="{{ URL::asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ URL::asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
 <script src="{{ URL::asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
 <script src="{{ URL::asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
 <!-- Optional JS -->
 <script src="../assets/vendor/chart.js/dist/Chart.min.js"></script>
 <script src="../assets/vendor/chart.js/dist/Chart.extension.js"></script>
 <!-- Argon JS -->
 <script src="../assets/js/argon.js?v=1.2.0"></script>
</body>

</html>