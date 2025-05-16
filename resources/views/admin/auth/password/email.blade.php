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
        <form class="saveForm" data-storeURL="{{ route('admin.password.sendResetEmail') }}">
          <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <p></p>
          </div>
          <div class="d-flex flex-wrap justify-content-end">
            <a href="{{ route('admin.loginForm') }}" class="text-dark">Login</a>
          </div>
          <div class="row">
            <div class="col-mb-4 mt-2">
              <button type="submit" class="btn btn-dark btn-block">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection