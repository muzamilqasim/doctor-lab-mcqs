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
        <form class="saveForm" data-storeURL="{{ route('admin.password.verify.code') }}">
          <div class="mb-3">
            <input type="hidden" name="email" value="{{ $email }}">
          </div>
          <div class="input-group mb-3">
            <input type="text" name="code" class="form-control" placeholder="Enter Code" autocomplete="off">
            <p></p>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-mb-4 mt-2">
              <button type="submit" class="btn btn-dark btn-block">Verify</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection