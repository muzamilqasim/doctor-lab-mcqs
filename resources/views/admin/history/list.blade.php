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
    <div class="container-fluid">
    <div class="message"></div>
        <div class="card">
        <div class="card-body table-responsive">                                 
            <table id="datatable" class="table table-hover text-nowrap text-center">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Plan Title</th>
                        <th>User</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                 <tbody>
                    @forelse($subscriptions as $index => $row)
                    <tr>
                        <td>{{ paginationIndex($subscriptions, $index) }}</td>
                        <td>{{ $row->package->title }}</td>
                        <td>{{ $row->user->first_name . ' ' .$row->user->last_name }}</td>
                        <td>{{ showDate($row->expires_at) }}</td>
                        <td>
                            @if($row->status === 'expired')
                                <span class="badge bg-danger">Expired</span>
                            @elseif($row->status === 'cancel')
                                <span class="badge bg-warning">Canceled</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Record not found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>  
            <div class="mt-2">
                {{ $subscriptions->links('admin.partials.pagination') }}
            </div>                              
        </div>
    </div>
</div>
</section>
@endsection