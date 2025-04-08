@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-sm-2 justify-content-end d-flex">
                <a href="{{ route('admin.dashboard.password') }}" class="btn btn-outline-dark">Change Password</a>
            </div>  
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="message"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="saveForm" data-storeURL="{{ route('admin.dashboard.profile.update', $admin->id) }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $admin->name }}" class="form-control" placeholder="Name">   
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" value="{{ $admin->email }}" class="form-control" placeholder="Email">   
                                        <p></p>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" value="{{ $admin->username }}" class="form-control" placeholder="Username">   
                                        <p></p>
                                    </div>
                                </div>                                    
                                <div class="pb-5 pt-3">
                                    <button type="submit" class="btn btn-dark">Update</button>
                                </div>
                            </div>
                            @method('PUT')
                        </form>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection