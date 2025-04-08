@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.notification.markAll') }}" class="btn btn-outline-dark">Mark All Read</a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
    <div class="message"></div>
        <div class="card">
        <div class="card-body table-responsive">                                 
            <table id="datatable" class="table table-hover text-nowrap text-center">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                 <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ $row->click_url }}">
                                <i class="fa fa-desktop"></i>
                            </a>
                            <a href="#" data-destroy="{{ route('admin.notification.destroy', $row->id) }}" class="btn btn-sm btn-outline-danger deleteAction mr-1">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Record not found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>                              
        </div>
    </div>
</div>
</section>
@include('admin.partials.confirmDelete')
@endsection