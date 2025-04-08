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
                <a href="{{ route('front.home') }}" class="btn btn-outline-dark"><i class="fas fa-home"></i> Home</a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="message"></div> 
    <div class="container-fluid">
        <form class="saveForm" data-storeURL="{{ route('admin.home.update') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="heading">Heading</label>
                                        <input type="text" name="heading" id="heading" value="{{ $home->heading }}" class="form-control" placeholder="Heading">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="sub_heading">Sub-Heading</label>
                                        <input type="text" name="sub_heading" id="sub_heading" value="{{ $home->sub_heading }}" class="form-control" placeholder="Sub Heading">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="col-md-12 mt-2">
                                        <img src="{{ getImage(getFilePath('homeImage') . '/' . $home->image) }}" class="img-fluid img-thumbnail" id="previewImage" width="250">
                                        <br>
                                        <label for="image" class="p-2 mt-2 btn btn-primary">Upload Image</label>
                                    </div>
                                        <small class="ml-2 text-muted">Supported files: jpeg, jpg, png.</small>
                                    <input type="file" name="image" id="image" class="form-control input-opacity-none d-none" accept=".png, .jpg, .jpeg">  
                                    <p></p> 
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="about_title">About Title</label>
                                        <input type="text" name="about_title" id="about_title" value="{{ $home->about_title }}" class="form-control" placeholder="About Title">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="about_content">About Content</label>
                                        <textarea class="form-control" name="about_content" id="about_content">{!! $home->about_content !!}</textarea>
                                        <p></p>
                                    </div>
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
    $('#about_content').summernote({
        height: 300, 
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']], 
            ['color', ['color']],
            ['insert', ['link', 'picture']], 
        ]
    });
    $('#image').on('change', function (event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(file); 
        }
    });
});
</script>
@endpush