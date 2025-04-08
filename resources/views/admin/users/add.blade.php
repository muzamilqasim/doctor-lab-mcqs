@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark">Back</a>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="message"></div>
	<div class="container-fluid">
		<form class="saveForm" data-storeURL="{{ route('admin.users.store') }}">
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label for="first_name">First Name</label>
										<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="last_name">Last Name</label>
										<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="email">Email</label>
										<input type="email" name="email" id="email" class="form-control" placeholder="Email">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="phone_number">Phone Number (Optional)</label>
										<input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="password">Password</label>
										<input type="password" name="password" id="password" class="form-control" placeholder="Password">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="career_stage">Career Stage</label>
										<select class="form-control" name="career_stage" id="career_stage">
											<option value="">Select Career Stage</option>
											@foreach($career as $row)
												<option value="{{ $row->id }}">{{ $row->name }}</option>
											@endforeach
										</select>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
								    <div class="mb-3">
								        <div class="d-flex align-items-center">
								            <label for="status" class="me-5 mb-0">Status:</label>
								            <div class="form-check form-switch">
								                <input class="form-check-input form-switch-color" type="checkbox" id="statusSwitch">
								                <input type="hidden" name="status" id="status" value="0">
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
				<button type="submit" class="btn btn-dark">Save</button>
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