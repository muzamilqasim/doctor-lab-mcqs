@extends('front.layouts.app')
@section('panel')
<div class="container-fluid py-5">
    <div class="container">
        @include('front.partials.message')
        <div class="row gy-5 gx-4">
            <div class="col-lg-9">
                <div class="mb-3">
                    <div class="mb-3">
                        <span class="px-3 py-1 text-white" style="background: #007bff; border-radius: 20px;">
                            {{ $question->category->name }}
                        </span>
                        @if(!empty($question->subCategory->name))
                        <span class="px-3 py-1 text-white" style="background: #17a2b8; border-radius: 20px;">
                            {{ $question->subCategory->name ?? '' }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <h4 class="text-primary">{{ $question->title }}</h4>
                    @if($question->question_image)
                    <img src="{{ getImage(getFilePath('questionImage') . '/' . $question->question_image) }}" alt="Question Image" class="img-fluid img-thumbnail mb-3" width="35%">
                    @endif
                    <p class="text-dark">{{ $question->question_text }}</p>
                </div>

                @if(isset($selectedOptionId))
                <div class="mt-3">
                    <h5>Your Answer:</h5>
                    @php
                    $selectedOption = $question->options->where('id', $selectedOptionId)->first();
                    @endphp
                    <p class="text-dark">
                        <strong>{{ $selectedOption->option_text }}</strong>
                        ({{ $selectedOption->is_correct ? 'Correct' : 'Incorrect' }})
                    </p>
                </div>
                @endif

                @if(isset($explanation) && $explanation)
                <hr class="mt-5">
                <div class="col-md-12">
                    <h4>Explanation: {{ $explanation->title }}</h4>
                    <p class="text-dark">{!! $explanation->description !!}</p>
                </div>
                <div class="col-md-12 mt-4">
                    <a href="{{ $nextQuestionId ? route('front.test.question', ['questionId' => $nextQuestionId]) : route('front.users.result') }}" 
                     class="btn btn-primary btn-rounded">
                     {{ $nextQuestionId ? 'Next Question' : 'Finish' }}
                 </a>
             </div>
             @else
             <!-- Answer Form -->
             <form action="{{ route('front.test.submitAnswer') }}" method="POST">
                @csrf
                <div class="col-md-12 text-dark">
                    @foreach($question->options as $option)
                    <div class="mb-3">
                        <label class="form-check-label d-flex align-items-center">
                            <input type="radio" name="answer" value="{{ $option->id }}" class="form-check-input me-2">
                            {{ $option->option_text }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
                        <a href="{{ route('front.category.showCategories') }}" class="btn btn-secondary btn-rounded">Back to Categories</a>
                    </div>
                    <div class="col-md-6 mt-4 text-end">
                        <a href="{{ $previousQuestionId ? route('front.test.question', ['questionId' => $previousQuestionId]) : '#' }}"
                         class="btn btn-secondary btn-rounded {{ $previousQuestionId ? '' : 'disabled' }}">
                         <i class="fas fa-arrow-left"></i>
                     </a>
                     <a href="{{ $nextQuestionId ? route('front.test.question', ['questionId' => $nextQuestionId]) : '#' }}"
                         class="btn btn-secondary btn-rounded {{ $nextQuestionId ? '' : 'disabled' }}">
                         <i class="fas fa-arrow-right"></i>
                     </a>
                 </div>
             </div>
         </form>
         @endif
     </div>
     <div class="col-lg-3">
        <div class="bg-light mt-1 rounded p-3">
            <h4>Scoreboard</h4>
            <table class="table">
                @foreach(session('questions', []) as $index => $questionId)
                @php
                $testResult = \App\Models\TestResult::where('user_id', auth()->id())
                ->where('question_id', $questionId)
                ->first();

                $icon = '<i class="fas fa-minus text-secondary"></i>';
                if ($testResult) {
                    $icon = ($testResult->is_correct == 'true')
                            ? '<i class="fas fa-check text-success"></i>'
                            : '<i class="fas fa-times text-danger"></i>'; 
                        }
                        @endphp
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <th>{!! $icon !!}</th>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
