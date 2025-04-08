@extends('front.layouts.app')

@section('panel')
<div id="category" class="container-fluid py-5">
    <div class="container">
        @include('front.partials.message')
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">{{ $pageTitle }}</h1>

        <div class="row justify-content-center">
            @foreach($packages as $package)
                @php
                    $userSubscription = auth()->user()->subscription ?? null;
                    $isSubscribedToThis = $userSubscription && $userSubscription->subscription_package_id === $package->id && $userSubscription->status === 'active' && $userSubscription->expires_at > now();
                @endphp

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-lg text-center p-4 h-100">
                        <div class="card-body">
                            <h3 class="card-title font-weight-bold">{{ $package->title }}</h3>
                            <h4 class="text-primary my-3">${{ $package->price }}</h4>
                            <p class="text-muted">Access for {{ $package->duration }} days</p>

                            @if($isSubscribedToThis)
                                <button class="btn btn-secondary w-100" disabled>Already Subscribed</button>
                            @else
                                <form action="{{ route('front.paypal.subscribe') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <button type="submit" class="btn btn-dark w-100">Subscribe Now</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
