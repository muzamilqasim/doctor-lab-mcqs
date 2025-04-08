@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $pageTitle }}</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="message"></div> 
    <div class="container-fluid">
        <form class="saveForm" data-storeURL="{{ route('admin.setting.update') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="site_title">Website Title</label>
                                        <input type="text" name="site_title" id="site_title" value="{{ $general->site_title }}" class="form-control" placeholder="Website Title">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="email">Site Email</label>
                                        <input type="email" name="email" id="email" value="{{ $general->email }}" class="form-control" placeholder="Site Email">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="contact">Contact</label>
                                        <input type="text" name="contact" id="contact" value="{{ $general->contact }}" class="form-control" placeholder="Site Contact Number">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="copyright_text">Copyright</label>
                                        <input type="text" name="copyright_text" id="copyright_text" value="{{ $general->copyright_text }}" class="form-control" placeholder="Copyright Text">
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