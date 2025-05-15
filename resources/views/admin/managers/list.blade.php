@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.managers.create') }}" class="btn btn-outline-dark">Add Manager</a>
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
                            <th>Sr#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                        <tr>
                            <td>{{ paginationIndex($data, $index) }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->username }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-success" href="{{ route('admin.managers.edit', $row->id) }}">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="#" data-destroy="{{ route('admin.managers.destroy', $row->id) }}" 
                                 class="btn btn-sm btn-outline-danger deleteAction mr-1">
                                    <i class="fa fa-trash"></i>
                                </a>
                         </td>
                     </tr>
                     @empty
                     <tr>
                        <td colspan="7">Record not found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table> 
            <div class="mt-2">
                {{ $data->links('admin.partials.pagination') }}
            </div>                              
        </div>
    </div>
</div>
</section>
@include('admin.partials.confirmDelete')
@endsection