@extends('admin.layouts.master')
@section('content')
<div class="login-page">
  <div class="message"></div>
  <div class="login-box">
    <div class="card">
      <a href="#" class="mt-2 login-logo">
        <h1>{{ $general->site_title }}</h1>
      </a> 
      <div class="card-body login-card-body">
        <form class="saveForm" data-storeURL="{{ route('admin.password.change') }}">
          <input type="hidden" name="email" value="{{ $email }}">
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <p></p>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <p></p>
          </div>
          <div class="row">
            <div class="col-mb-4 mt-2">
              <button type="submit" class="btn btn-dark btn-block">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection