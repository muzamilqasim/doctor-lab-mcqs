@extends('front.layouts.app')

@section('panel')
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            @include('front.partials.sidebar')
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-3 col-6 bg-secondary m-1 p-2 text-white rounded">
                        <div class="small-box">
                            <div class="inner">
                                <h3 class="text-white">{{ $totalAttempt }}</h3>
                                <p>Attempt Questions</p>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="card mt-4 shadow-lg rounded-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="mb-0">Subscription Details</h5>
                    </div>
                    <div class="card-body">
                        @if($subscription)
                        <div class="text-center">
                            <h4 class="text-primary font-weight-bold">{{ $subscription->package->title }}</h4>
                            <h5 class="text-success mt-2">${{ $subscription->package->price }}</h5>
                            <p class="text-muted">Access Duration: <strong>{{ $subscription->package->duration }} days</strong></p>
                            <hr>
                            <p><strong>Subscription Status:</strong> 
                                <span class="badge bg-success">Active</span>
                            </p>
                            <p><strong>Expiry Date:</strong> {{ showDate($subscription->expires_at) }}</p>
                            
                            <p class="mt-3">
                                <strong>Remaining Days:</strong> 
                                <span class="text-primary">{{ $remainingDays }} days left</span>
                            </p>
                        </div>
                        @else
                        <div class="text-center text-muted">
                            <p>You have no active subscription.</p>
                            <a href="{{ route('front.package') }}" class="btn btn-primary mt-2">Browse Plans</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
