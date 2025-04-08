@extends('admin.layouts.app')
@section('panel')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $pageTitle }}</h1>
          </div>
        </div>
      </div>
    </div> 
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-custom">
              <div class="inner">
                <h3>{{ $totalCategories }}</h3>
                <p>Categories</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="{{ route('admin.categories.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-custom">
              <div class="inner">
                <h3>{{ $totalSubCategories }}</h3>
                <p>Sub-Categories</p>
              </div>
              <div class="icon">
                <i class="fas fa-th"></i>
              </div>
              <a href="{{ route('admin.subCategories.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-custom">
              <div class="inner">
                <h3>{{ $totalQuestions }}</h3>
                <p>Questions</p>
              </div>
              <div class="icon">
                <i class="fas fa-question"></i>
              </div>
              <a href="{{ route('admin.questions.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-custom">
              <div class="inner">
                <h3>{{ $totalUser }}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection