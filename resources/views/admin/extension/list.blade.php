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
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Extension</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                 <tbody>
                    @forelse($extensions as $extension)
                    <tr>
                        <td>
                            <img src="{{ getImage(getFilePath('extensions'). '/' . $extension->image, getFileSize('extensions')) }}" class="img-fluid img-thumbnail mr-2" width="5%" />
                            <span class="name">{{ $extension->name }}</span>
                        </td>
                        <td>
                            @php echo $extension->statusBadge; @endphp
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info editBtn" data-name="{{ __($extension->name) }}" data-shortcode="{{ json_encode($extension->shortcode) }}" data-action="{{ route('admin.extension.update', $extension->id) }}">
                                <i class="la la-cogs"></i> Configure
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark helpBtn" data-description="{{ __($extension->description) }}" data-support="{{ __($extension->support) }}">
                                <i class="la la-question"></i> Help
                            </button>
                            @if($extension->status == 0)
                                <a href="{{ route('admin.extension.status', $extension->id) }}" class="btn btn-sm btn-outline-success mr-1">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.extension.status', $extension->id) }}" class="btn btn-sm btn-outline-danger mr-1">
                                    <i class="fa fa-eye-slash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="3">Extension Not Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>                                
        </div>
    </div>

        <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Extension: <span class="extension-name"></span></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-12 control-label fw-bold">Script</label>
                                <div class="col-md-12">
                                    <textarea name="script" class="form-control" required rows="8" placeholder="Paste your script with proper key">{{ old('script') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark w-100 h-45" id="editBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="helpModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Need Help?</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@push('script')
<script>
    $(function() {
        $(document).on('click', '.editBtn', function() {
            var modal = $('#editModal');
            var shortcode = $(this).data('shortcode');

            modal.find('.extension-name').text($(this).data('name'));
            modal.find('form').attr('action', $(this).data('action'));

            var html = '';
            $.each(shortcode, function(key, item) {
                html += '<div class="form-group">' +
                    '<label class="col-md-12 control-label fw-bold">' + item.title + '</label>' +
                    '<div class="col-md-12">' +
                    '<input name="' + key + '" class="form-control" placeholder="--" value="' + item.value + '" required>' +
                    '</div>' +
                    '</div>';
            });
            modal.find('.modal-body').html(html);

            modal.modal('show');
        });
        $(document).on('click', '.helpBtn', function() {
            var modal = $('#helpModal');
            var path = "{{ asset(getFilePath('extensions')) }}";
            var description = $(this).data('description');

            modal.find('.modal-body').html('<div class="mb-2">' + description + '</div>');
            if ($(this).data('support') != '') {
                modal.find('.modal-body').append(`<img src="${path}/${$(this).data('support')}" width='100%'>`);
            }
            modal.modal('show');
        });
    });

</script>
@endpush