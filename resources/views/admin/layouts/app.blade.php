@extends('admin.layouts.master')
@section('content')
<div class="sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('admin.partials.navbar') 
    @include('admin.partials.sidebar')
    <div class="content-wrapper">
      @yield('panel')
    </div>
    @include('admin.partials.footer')
  </div>
</div>
@endsection 