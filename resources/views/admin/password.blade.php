@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-sm-2 justify-content-end d-flex">
                <a href="{{ route('admin.dashboard.profile') }}" class="btn btn-outline-dark">Profile Setting</a>
            </div>
        </div>
    </div>
</section> 
<section class="content">
    <div class="message"></div>
    <div class="container-fluid">
        <form class="saveForm" data-storeURL="{{ route('admin.dashboard.password.update') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                        
                        <div class="p-3">
                            <button type="submit" class="btn btn-dark">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection