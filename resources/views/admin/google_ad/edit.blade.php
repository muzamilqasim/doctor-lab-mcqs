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
		<form class="saveForm" data-storeURL="{{ route('admin.google_ad.update', $data->id) }}">
			@method('PUT')
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="ad_name">Ad Name</label>
										<input type="text" name="ad_name" id="ad_name" value="{{ $data->ad_name }}" class="form-control" placeholder="Ad Name">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="position">Ad Position</label>
										<select class="form-control" name="position" id="position">
											<option value="ad_1" {{ ($data->position == 'ad_1') ? 'selected' : '' }}>First</option>
											<option value="ad_2" {{ ($data->position == 'ad_2') ? 'selected' : '' }}>Second</option>
											<option value="ad_3" {{ ($data->position == 'ad_3') ? 'selected' : '' }}>Third</option>
										</select>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="ad_code">Ad Code</label>
										<textarea name="ad_code" id="ad_code" class="form-control" placeholder="Paste Google Ad Code Here">{!! $data->ad_code !!}</textarea>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
								    <div class="mb-3">
								        <div class="d-flex align-items-center">
								            <label for="status" class="me-5 mb-0">Status:</label>
								            <div class="form-check form-switch">
								                <input class="form-check-input form-switch-color" {{ ($data->status == 'Active') ? 'checked' : ''  }} type="checkbox" id="statusSwitch">
								                <input type="hidden" name="status" id="status" value="{{ $data->status }}">
								            </div>
								        </div>
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
@push('script')
<script>
$(document).ready(function() {
        const statusSwitch = $('#statusSwitch');
        const statusInput = $('#status');
        function updateSwitchColor() {
            if (statusSwitch.is(':checked')) {
                statusSwitch.addClass('checked');
                statusInput.val('Active');
            } else {
                statusSwitch.removeClass('checked');
                statusInput.val('Inactive');
            }
        }
        updateSwitchColor();
        statusSwitch.on('change', updateSwitchColor);
    });
</script>
@endpush