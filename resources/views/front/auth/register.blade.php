@extends('front.layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Sign Up</h1>
        <div class="row g-4">
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img class="img-fluid w-100" src="{{ asset('assets/front/images/login.svg') }}">
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp mt-5" data-wow-delay="0.5s">
                    <form class="saveForm" data-storeURL="{{ route('front.signUp') }}">
                        <div class="message"></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control first_name" name="first_name" id="first_name" placeholder="First Name" required>
                                    <p></p>
                                    <label for="first_name">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control last_name" name="last_name" id="last_name" placeholder="Last Name" required>
                                    <p></p>
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control email" name="email" id="email" placeholder="Email Address" required>
                                    <p></p>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" pattern="[0-9]{11}" class="form-control phone_number" id="phone_number" name="phone_number" placeholder="Phone Number" title="Please enter a valid phone number in the format." required>
                                    <p></p>
                                    <label for="phone_number">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" name="career_stage" id="career_stage">
                                        <option value="">Select Career Stage</option>
                                        @foreach($career as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                    <label for="career_stage">Career Stage</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control password" name="password" id="password" placeholder="Password" required>
                                    <p></p>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control password_confirmation" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                    <p></p>
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                            </div>
                            <x-captcha />
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3 btn-rounded" type="submit">Sign Up</button>
                            </div>
                            <div class="col-12">
                                <span>Already have an account? <a href="{{ route('front.loginForm') }}" class="text-primary">Sign In</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
