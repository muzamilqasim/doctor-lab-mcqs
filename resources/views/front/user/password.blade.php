@extends('front.layouts.app')
@section('panel')
<div class="container-fluid py-5">
    <div class="container p-5">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Change Password</h1>
        <div class="row g-4">
            <div class="col-md-12">
                <div class="wow fadeInUp mt-5" data-wow-delay="0.5s">
                    <form class="saveForm" data-storeURL="{{ route('front.users.passwordUpdate') }}">
                        <div class="col-12 p-2 text-end">
                            <a href="{{ route('front.users.edit') }}" class="btn btn-primary btn-rounded btn-sm">Back</a>
                        </div>
                        <div class="message"></div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control old_password" name="old_password"  required placeholder="Old Password">
                                    <label>Old Password</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control new_password" name="new_password" placeholder="New Password" required>
                                    <label>New Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3 btn-rounded" type="submit">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection