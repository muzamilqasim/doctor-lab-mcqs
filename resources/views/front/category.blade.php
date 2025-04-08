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
            <div class="row">
                @forelse($categories as $index => $category)
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                   <label class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input category-checkbox me-2" data-category-id="{{ $category->id }}">
                                        <span>
                                            <strong>{{ $category->name }}</strong> ({{ $category->questions_count }} questions)
                                        </span>
                                    </label>
                                </td>
                            </tr>

                            @if($category->subcategories->isNotEmpty())
                                <tr class="subcategory-row" data-category-id="{{ $category->id }}" style="display: none;">
                                    <td class="ps-4">
                                        <ul class="list-unstyled">
                                            @foreach($category->subcategories as $subcategory)
                                            <li>
                                                <label class="d-flex align-items-center">
                                                    <input type="checkbox" name="category_ids[]" value="{{ $subcategory->id }}" class="form-check-input subcategory-checkbox me-2" data-category-id="{{ $category->id }}">
                                                    {{ $subcategory->name }} ({{ $subcategory->questions_count }} questions)
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(($index + 1) % 2 == 0)
                <div class="w-100"></div>
                @endif
                @empty
                <div class="col-12 text-center">
                    <p>No Record found</p>
                </div>
                @endforelse
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

    categoryCheckboxes.forEach(categoryCheckbox => {
        categoryCheckbox.addEventListener('change', function() {
            const categoryId = this.dataset.categoryId;
            const subcategoryRow = document.querySelector(`.subcategory-row[data-category-id="${categoryId}"]`);
            const subcategoryCheckboxes = document.querySelectorAll(`.subcategory-checkbox[data-category-id="${categoryId}"]`);

            if (subcategoryRow) {
                subcategoryRow.style.display = this.checked ? 'table-row' : 'none';
                subcategoryCheckboxes.forEach(subCheckbox => {
                    subCheckbox.checked = this.checked;
                });
            }
        });
    });
});
</script>
@endpush
