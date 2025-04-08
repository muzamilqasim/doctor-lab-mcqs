@extends('front.layouts.app')

@section('panel')
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            @include('front.partials.sidebar')

            <div class="col-lg-8">
                <div class="card mt-4 shadow-lg rounded-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="mb-0">Plan History</h5>
                    </div>
                    <div class="card-body">
                        @if($subscriptions->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Plan Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Expiry Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscriptions as $key => $subscription)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $subscription->package->title }}</td>
                                            <td>${{ $subscription->package->price }}</td>
                                            <td>
                                                @if($subscription->status === 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @elseif($subscription->status === 'cancel')
                                                    <span class="badge bg-warning">Canceled</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>{{ showDate($subscription->expires_at) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                        <div class="text-center text-muted">
                            <p>No previous subscription history found.</p>
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
