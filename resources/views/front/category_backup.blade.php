@extends('front.layouts.app')
@section('panel')
<div id="category" class="container-fluid py-5">
    <div class="container">
        @include('front.partials.message')

        <form action="{{ route('front.test.start') }}" method="POST">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="wow fadeInUp" data-wow-delay="0.1s">Explore By Categories</h1>
                <button type="submit" class="btn btn-primary btn-rounded">Start Test</button>
            </div>
            <div class="row g-4">
                @forelse($categories as $row)
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="cat-item text-primary rounded p-4">
                        <label class="d-flex align-items-center">
                            <input type="checkbox" name="category_ids[]" value="{{ $row->id }}" class="form-check-input me-2">
                            {{ $row->name }} ({{ $row->questions_count }} questions)
                        </label>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <p>No Record found</p>
                </div>
                @endforelse
            </div>
        </form>            
    </div>
</div>
@endsection
