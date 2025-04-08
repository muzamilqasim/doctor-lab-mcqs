<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>

    <link href="{{ asset('assets/front/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/style.css?v=0.2') }}" rel="stylesheet">
</head>
<body>
 <div class="container-fluid bg-white p-0">
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    @include('front.partials.navbar')
    @yield('content')
    @include('front.partials.footer')
    <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top">
        <i class="fas fa-arrow-up text-white"></i>
    </a>
</div>

<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/front/js/main.js?v=1.1') }}"></script>
<script src="{{ asset('assets/front/js/action.js?v=1.1') }}"></script>
@stack('script')
</body>
</html>