@extends('front.layouts.app')
@section('panel')
<div class="container-fluid py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Update Profile</h1>
        <div class="row g-4">
            <div class="col-md-12">
                <div class="wow fadeInUp" data-wow-delay="0.5s">
                    <form class="saveForm" data-storeURL="{{ route('front.users.update') }}">
                        <div class="col-12 p-2 text-end">
                            @if(!user()->google_login == 1)
                                <a href="{{ route('front.users.password') }}" class="btn btn-primary btn-rounded btn-sm">Change Password</a>
                            @endif
                            <a href="{{ route('front.users.profile') }}" class="btn btn-primary btn-rounded btn-sm">Back</a>
                        </div>
                        <div class="message"></div>
                        <div class="row g-3">
                            <div class="col-md-12 text-center">
                                <div class="col-md-12 mt-2">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . user()->image) }}" class="img-fluid img-thumbnail" id="previewImage" width="250">
                                    <br>
                                    <label for="image" class="p-2 mt-2 btn btn-primary">Upload Image</label>
                                </div>
                                    <small class="ml-2 text-muted">Supported files: jpeg, jpg, png. Image will be resized into 400x400px</small>
                                <input type="file" name="image" id="image" class="form-control input-opacity-none d-none" accept=".png, .jpg, .jpeg">  
                                <p></p> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control first_name" name="first_name" id="first_name" placeholder="First Name" value="{{ user()->first_name }}" required>
                                    <p></p>
                                    <label for="first_name">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control last_name" name="last_name" id="last_name" placeholder="Last Name" value="{{ user()->last_name }}" required>
                                    <p></p>
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" name="career_stage" id="career_stage">
                                        <option value="">Select Career Stage</option>
                                        @foreach($career as $row)
                                        <option value="{{ $row->id }}" {{ ($row->id == user()->career_stage_id) ? 'selected' : '' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                    <label for="career_stage">Career Stage</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control email" id="email" name="email" placeholder="Email" value="{{ user()->email }}" required>
                                    <p></p>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="tel" pattern="[0-9]{11}" class="form-control phone_number" name="phone_number" title="Please enter a valid phone number in the format." id="phone_number" placeholder="Phone Number" value="{{ user()->phone_number ?? '' }}" required>
                                    <p></p>
                                    <label for="phone_number">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3 btn-rounded" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
$(document).ready(function () {
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