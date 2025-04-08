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
		<form class="saveForm" data-storeURL="{{ route('admin.questions.store') }}">
			<div class="row">
				<div class="col-md-7">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-6">
									<div class="col-md-5 mt-2">
										<img src="{{ getImage(getFilePath('questionImage')) }}" class="img-fluid img-thumbnail" id="previewImage" width="250">
										<label for="question_image" class="btn-dark p-2 mt-2 btn btn-block">Upload Image</label>
									</div>
									<small class="ml-2 text-muted">Supported files: jpeg, jpg, png.</small>
									<input type="file" name="question_image" id="question_image" class="form-control input-opacity-none d-none" accept=".png, .jpg, .jpeg">  
									<p></p> 
								</div> 
								<div class="col-md-12">
									<div class="mb-3">
										<label for="title">Cateogry</label>
										<select class="form-control" name="categories" id="categories">
											<option value="">Select Cateogry</option>
											@foreach($categories as $row)
											<option value="{{ $row->id }}">{{ $row->name }}</option>
											@endforeach
										</select>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
								    <div class="mb-3">
								        <label for="subCategories">Subcategory</label>
								        <select class="form-control" name="subCategories" id="subCategories">
								            <option value="">Select Subcategory</option>
								        </select>
								        <p></p>
								    </div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="title">Title</label>
										<input type="text" name="title" id="title" class="form-control" placeholder="Title">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="question_text">Question Text</label>
										<textarea class="form-control" name="question_text" id="question_text"></textarea>
										<p></p>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<h4>Explaination</h4>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="explaination_title">Title</label>
										<input type="text" name="explaination_title" id="explaination_title" class="form-control">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="description">Explaination</label>
										<textarea class="form-control" id="description" name="description"></textarea>
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
									<h4>Options</h4>
									<div id="options-container">
										<div class="option-row d-flex mb-2">
											<textarea class="form-control me-2" name="options[0][option_text]" placeholder="Option Text"></textarea>
											<select class="form-control me-2" name="options[0][is_correct]">
												<option value="true">True</option>
												<option value="false">False</option>
											</select>
											<button type="button" class="btn btn-danger remove-option">-</button>
										</div>
									</div>
									<button type="button" class="btn btn-success mt-2" id="add-option">+ Add Option</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-dark">Save</button>
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
		let optionIndex = 1;
		$('#add-option').on('click', function () {
			const newOptionRow = `
            <div class="option-row d-flex mb-2">
                <textarea class="form-control me-2" name="options[${optionIndex}][option_text]" placeholder="Option Text"></textarea>
                <select class="form-control me-2" name="options[${optionIndex}][is_correct]">
                    <option value="true">True</option>
                    <option value="false">False</option>
                </select>
                <button type="button" class="btn btn-danger remove-option">-</button>
				</div>`;
				$('#options-container').append(newOptionRow);
				optionIndex++;
			});
		$(document).on('click', '.remove-option', function () {
			$(this).closest('.option-row').remove();
		});

        $('#categories').on('change', function () {
	        var categoryId = $(this).val(); 
	        $('#subCategories').html('<option value="">Loading...</option>');

	        if (categoryId) {
	            $.ajax({
	                url: "{{ route('admin.subCategories.getSubcategories') }}",
	                type: "GET",
	                data: { categoryID: categoryId }, 
	                dataType: "json",
	                success: function (data) {
	                    $('#subCategories').html('<option value="">Select Subcategory</option>');
	                    $.each(data, function (key, value) {
	                        $('#subCategories').append('<option value="' + value.id + '">' + value.name + '</option>');
	                    });
	                },
	                error: function () {
	                    $('#subCategories').html('<option value="">Failed to load subcategories</option>');
	                }
	            });
	        } else {
	            $('#subCategories').html('<option value="">Select Subcategory</option>');
	        }
	    });
    });
</script>
@endpush