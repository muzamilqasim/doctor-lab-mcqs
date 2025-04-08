@extends('front.layouts.app')
@section('panel')
<div class="container-fluid p-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
            <h1 class="mb-4 text-gradient">{{ $home->heading }}</h1>
            <p class="lead mb-4 text-muted">{{ $home->sub_heading }}</p>
            <a class="btn btn-primary btn-lg me-3" href="{{ route('front.register') }}">Sign Up</a>
            <a class="btn btn-outline-secondary btn-lg" href="#about">About</a>
        </div>
        <div class="col-lg-6 text-center wow fadeIn" data-wow-delay="0.1s">
            <img class="img-fluid rounded-3 shadow-lg" src="{{ getImage(getFilePath('homeImage') . '/' . $home->image) }}">
        </div>
    </div>
</div>

<!-- Ad Placeholder Start -->
<div class="container-fluid text-center py-4">
    <div class="col-md-12">
        <img src="{{ asset('assets/front/images/banner-placeholder.jpg') }}" alt="Ad Placeholder" class="img-fluid rounded-3 shadow-sm">
    </div>
</div>
<!-- Ad Placeholder End -->

<!-- Category Start -->
<div id="category" class="container-fluid py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Explore By Categories</h1>
        <div class="row g-4">
            @forelse($categories as $row)
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="cat-item text-primary rounded-3 p-4 bg-light shadow-sm" href="{{ route('front.category.showCategories') }}">
                        <h5 class="fw-bold">{{ $row->name }}</h5>
                        <p class="text-muted">Questions: {{ $row->questions_count }}</p>
                    </a>
                </div>
            @empty
                <div class="text-center">
                    <p>No Record found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Category End -->

<!-- About Start -->
<div id="about" class="container-fluid py-5 bg-dark text-white">
    <div class="container p-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 text-center wow fadeIn" data-wow-delay="0.5s">
                <h1 class="mb-4 text-white">{{ $home->about_title }}</h1>
                <p class="lead">{!! $home->about_content !!}</p>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Subscription Packages Start -->
<div id="packages" class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($packages as $package)
                @php
                    $userSubscription = auth()->user()->subscription ?? null;
                    $isSubscribedToThis = $userSubscription && $userSubscription->subscription_package_id === $package->id && $userSubscription->status === 'active' && $userSubscription->expires_at > now();
                @endphp
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-4 text-center p-4 h-100">
                        <div class="card-body">
                            <h3 class="card-title fw-bold">{{ $package->title }}</h3>
                            <h4 class="text-success my-3">${{ $package->price }}</h4>
                            <p class="text-muted">Access for {{ $package->duration }} days</p>

                            @if($isSubscribedToThis)
                                <button class="btn btn-secondary w-100" disabled>Already Subscribed</button>
                            @else
                                <form action="{{ route('front.paypal.subscribe') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <button type="submit" class="btn btn-primary w-100">Subscribe Now</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Subscription Packages End -->

<!-- Ad Placeholder Start -->
<div class="container-fluid text-center my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('assets/front/images/banner-placeholder.jpg') }}" alt="Ad Placeholder" class="img-fluid rounded-3 shadow-sm">
        </div>
        <div class="col-md-6">
            <img src="{{ asset('assets/front/images/banner-placeholder.jpg') }}" alt="Ad Placeholder" class="img-fluid rounded-3 shadow-sm">
        </div>
    </div>
</div>
<!-- Ad Placeholder End -->
@endsection
