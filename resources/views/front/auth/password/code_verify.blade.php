@extends('front.layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container p-5">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Verification Code</h1>
        <div class="row g-4">
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img class="img-fluid w-100" src="{{ asset('assets/front/images/login.svg') }}">
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp mt-5" data-wow-delay="0.5s">
                    <form class="saveForm" data-storeURL="{{ route('front.password.verify.code') }}">
                        <div class="message"></div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control code" name="code" id="code" placeholder="Code" required>
                                    <p></p>
                                    <label for="code">Code</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-rounded" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection