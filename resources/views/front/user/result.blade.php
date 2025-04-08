@extends('front.layouts.app')
@section('panel')
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            @include('front.partials.sidebar')
            <div class="col-lg-8 mt-1">
                <div class="accordion" id="testResultsAccordion">
                    @foreach($testResults as $index => $result)
                    <div class="card shadow-sm mb-3">
                        <div class="card-header" id="heading{{ $index }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-decoration-none w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    <span class="text-primary">{{ $result->question->title }}</span>
                                </button>
                            </h5>
                        </div>
                        <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#testResultsAccordion">
                            <div class="card-body">
                                <p class="card-text text-dark">{{ $result->question->question_text }}</p>

                                @php
                                    // Fetch user-selected option
                                    $selectedOption = $result->question->options->where('id', $result->answer)->first();
                                    // Fetch correct option
                                    $correctOption = $result->question->options->where('is_correct', 'true')->first();
                                    // Fetch explanation
                                    $explanation = $result->question->explanation;
                                @endphp

                                <p>
                                    Your Answer: 
                                    <span class="fw-bold {{ $result->is_correct == 'true' ? 'text-success' : 'text-danger' }}">
                                        {{ $result->is_correct == 'true' ? 'Correct' : 'Incorrect' }}
                                    </span>
                                </p>

                                <p>
                                    Selected Option: 
                                    <span class="fw-bold text-dark">
                                        {{ $selectedOption ? $selectedOption->option_text : 'Not Available' }}
                                    </span>
                                </p>

                                <p>
                                    Correct Answer: 
                                    <span class="fw-bold text-primary">
                                        {{ $correctOption ? $correctOption->option_text : 'Not Available' }}
                                    </span>
                                </p>

                                <p>
                                    Explanation: 
                                    <span class="text-muted">
                                        {!! $explanation ? $explanation->description : 'No explanation provided' !!}
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
