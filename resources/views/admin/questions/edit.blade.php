@push('style')
<link rel="stylesheet" href="{{ asset('assets/admin/summernote/summernote-bs4.min.css') }}">
@endpush
@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('admin.questions.index') }}" class="btn btn-outline-dark">Back</a>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="message"></div>
	<div class="container-fluid">
		<form class="saveForm" data-storeURL="{{ route('admin.questions.update', $data->id) }}">
			@method('PUT')
			<div class="row">
				<div class="col-md-7">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-6">
                                    <div class="col-md-5 mt-2">
                                        <img src="{{ getImage(getFilePath('questionImage') . '/' . $data->question_image) }}" class="img-fluid img-thumbnail" id="previewImage" width="250">
                                        <label for="question_image" class="btn-dark p-2 mt-2 btn btn-block">Upload Image</label>
                                    </div>
                                        <small class="ml-2 text-muted">Supported files: jpeg, jpg, png.</small>
                                    <input type="file" name="question_image" id="question_image" class="form-control input-opacity-none d-none" accept=".png, .jpg, .jpeg">  
                                    <p></p> 
                                </div> 
								<div class="col-md-12">
									<div class="mb-3">
										<label for="categories">Cateogry</label>
										<select class="form-control" name="categories" id="categories" data-getsubcat="{{ route('admin.subCategories.getSubcategories') }}">
											<option value="">Select Cateogry</option>
											@foreach($categories as $row)
												<option value="{{ $row->id }}" {{ ($row->id == $data->category_id) ? 'selected' : '' }}>{{ $row->name }}</option>
											@endforeach
										</select>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
								    <div class="mb-3">
								        <label for="subCategories">Sub-Categories</label>
								        <select name="subCategories" id="subCategories" class="form-control">
								            <option value="" selected disabled>Select Sub-Category</option>
								            @foreach($subCategories as $row)
								                <option value="{{ $row->id }}" {{ $row->id == $data->sub_category_id ? 'selected' : '' }}>{{ $row->name }}</option>
								            @endforeach
								        </select>
								        <p></p>
								    </div>
								</div>
                                <div class="col-md-12">
									<div class="mb-3">
										<label for="title">Title</label>
										<input type="text" name="title" id="title" value="{{ $data->title }}" class="form-control" placeholder="Title">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="question_text">Question Text</label>
										<textarea class="form-control" name="question_text" id="question_text">{{ $data->question_text }}</textarea>
										<p></p>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="explaination_title">Title</label>
										<input type="text" name="explaination_title" id="explaination_title" value="{{ $explanation->title }}" class="form-control">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="description">Explaination</label>
										<textarea class="form-control" id="description" name="description">{!! $explanation->description !!}</textarea>
									</div>
								</div>
							</div>
						</div>                                                                        
					</div>
				</div>
				<div class="col-sm-5">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-12">
									<label for="options">Options</label>
									<div id="options-container">
										@foreach($options as $index => $opt)
										<div class="option-row d-flex mb-2">
											<input type="hidden" name="options[{{ $index }}][id]" value="{{ $opt->id }}">
											<textarea class="form-control me-2" name="options[{{ $index }}][option_text]">{{ $opt->option_text }}</textarea>
											<select class="form-control me-2" name="options[{{ $index }}][is_correct]">
												<option value="true" {{ $opt->is_correct == 'true' ? 'selected' : '' }}>True</option>
												<option value="false" {{ $opt->is_correct == 'false' ? 'selected' : '' }}>False</option>
											</select>
											<button type="button" class="btn btn-danger remove-option" onclick="removeOption(this)">-</button>
										</div>
										@endforeach
									</div>
									<button type="button" class="btn btn-success mt-2" id="add-option">+ Add Option</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-dark">Update</button>
			</div>
		</form>
	</div>
</section>
@endsection
@push('script')
<script src="{{ asset('assets/admin/summernote/summernote-bs4.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#description').summernote({
        height: 300, 
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']], 
            ['color', ['color']],
            ['insert', ['link', 'picture']], 
        ]
    });

    // Preview Image
    $('#question_image').on('change', function (event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(file); 
        }
    });

    // Initialize the option index based on existing options
    let optionIndex = $('#options-container .option-row').length;

    // Add new option
    $('#add-option').click(function () {
        const newRow = `
            <div class="option-row d-flex mb-2">
                <textarea class="form-control me-2" name="options[${optionIndex}][option_text]" placeholder="Option Text"></textarea>
                <select class="form-control me-2" name="options[${optionIndex}][is_correct]">
                    <option value="true">True</option>
                    <option value="false">False</option>
                </select>
                <button type="button" class="btn btn-danger remove-option">-</button>
            </div>`;
        
        $('#options-container').append(newRow);
        optionIndex++; // Increment for next option
    });

    // Remove an option row dynamically
    $(document).on('click', '.remove-option', function () {
        $(this).closest('.option-row').remove();
        updateIndexes();
    });

    function updateIndexes() {
        // Reset optionIndex and update name attributes
        $('#options-container .option-row').each(function (index) {
            $(this).find('textarea').attr('name', `options[${index}][option_text]`);
            $(this).find('select').attr('name', `options[${index}][is_correct]`);
        });
        optionIndex = $('#options-container .option-row').length;
    }

    // Fetch subcategories dynamically
    $('#categories').change(function () {
        var category = $(this).val();
        var url = $(this).data('getsubcat');

        if (category) {
            $.ajax({
                url: url,
                type: 'GET',
                data: { categoryID: category },
                dataType: 'json',
                success: function (data) {
                    $("#subCategories").html('<option value="" selected disabled>Select Sub-Category</option>');
                    $.each(data, function (key, item) {
                        $('#subCategories').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                },
                error: function () {
                    console.log("Something went wrong while fetching subcategories.");
                }
            });
        } else {
            $("#subCategories").html('<option value="" selected disabled>Select Sub-Category</option>');
        }
    });
});

</script>
@endpush