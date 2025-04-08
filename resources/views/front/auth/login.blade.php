@extends('front.layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container p-5">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Sign In</h1>
        <div class="row g-4">
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img class="img-fluid w-100" src="{{ asset('assets/front/images/login.svg') }}">
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp mt-5" data-wow-delay="0.5s">
                    <form class="saveForm" data-storeURL="{{ route('front.login') }}">
                        <div class="message"></div>
                        <div class="row g-3 align-items-center">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control username" name="email" id="email" placeholder="Email" required>
                                    <p></p>
                                    <label for="subject">Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control password" id="password" name="password" placeholder="Password" required>
                                    <p></p>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-rounded" type="submit">Sign In</button>
                                <a href="{{ route('front.auth.google') }}" class="btn btn-danger btn-rounded">
                                    <i class="fab fa-google me-2"></i> Sign in with Google
                                </a>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('front.register') }}" class="btn btn-primary btn-rounded">Sign Up</a>
                                <a href="{{ route('front.password.reset') }}" class="btn-rounded btn btn-primary">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection