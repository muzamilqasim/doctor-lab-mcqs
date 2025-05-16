@extends('front.layouts.app')

@section('panel')
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            @include('front.partials.sidebar')
            <div class="col-lg-8">
                <!-- Compact Stats Row with Percentages -->
                <div class="row mb-4">
                    @php
                    $correctPercentage = $totalAttempt > 0 ? round(($correctAttempts / $totalAttempt) * 100) : 0;
                    $wrongPercentage = $totalAttempt > 0 ? round(($wrongAttempts / $totalAttempt) * 100) : 0;
                    @endphp
                    
                    <div class="col-md-4 mt-2 mb-3">
                        <div class="p-3 bg-secondary text-white rounded text-center">
                            <h5 class="mb-0 text-white">{{ $totalAttempt }}</h5>
                            <small>Total Attempts</small>
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-0 py-2">
                                <h6 class="mb-0 text-center">Your Performance</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="chart-container" style="position: relative; height:200px;">
                                    <canvas id="performanceChart"></canvas>
                                    <div class="chart-center-text" 
                                    style="position: absolute; 
                                    top: 40%; 
                                    left: 50%; 
                                    transform: translate(-50%, -50%);
                                    text-align: center;">
                                    <h5 class="mb-0">{{ $correctPercentage }}%</h5>
                                    <small class="text-muted">Correct</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white text-center py-2">
                    <h6 class="mb-0">Subscription Details</h6>
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

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const total = {{ $totalAttempt }};
        const correctPercentage = total > 0 ? Math.round(({{ $correctAttempts }} / total) * 100) : 0;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                    `Correct (${correctPercentage}%)`, 
                    `Wrong (${100 - correctPercentage}%)`
                    ],
                    datasets: [{
                        data: [{{ $correctAttempts }}, {{ $wrongAttempts }}],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 0
                        }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '75%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        padding: 20,
                                        font: {
                                            size: 11
                                            },
                                            usePointStyle: true
                                        }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.raw || 0;
                                                    return `${label}: ${value} answers`;
                                                }
                                            }
                                        }
                                    }
                                }
                                });
                                });
                            </script>
                            @endpush
                            @endsection