<div class="bg-light text-dark py-2">
    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center text-primary">
            <span class="me-3"><i class="fa fa-envelope me-2 text-primary"></i> {{ gs()->email }}</span>
            <span><i class="fa fa-phone me-2 text-primary"></i> {{ gs()->contact }}</span>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ route('front.home') }}" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
        <h1 class="m-0 text-primary">{{ $general->site_title }}</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('front.home') }}" class="nav-item nav-link {{ menuActive(['front.home']) }}"><b>Home</b></a>
            <a href="{{ route('front.package') }}" class="nav-item nav-link {{ menuActive(['front.package']) }}"><b>Packages</b></a>
            <a href="{{ route('front.category.showCategories') }}" class="nav-item nav-link {{ menuActive(['front.category.showCategories']) }}"><b>Categories</b></a>
        </div>
        @auth
            <a href="{{ route('front.users.profile') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block btn-login-border"><i class="fa fa-user"></i> {{ user()->first_name }}</a>
        @else
            <a href="{{ route('front.loginForm') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block btn-login-border">Sign In<i class="fa fa-sign-in-alt ms-3"></i></a>
        @endauth
    </div>
</nav>