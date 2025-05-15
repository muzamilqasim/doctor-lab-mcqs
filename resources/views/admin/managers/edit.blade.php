@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('admin.managers.index') }}" class="btn btn-outline-dark">Back</a>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="message"></div>
	<div class="container-fluid">
		<form class="saveForm" data-storeURL="{{ route('admin.managers.update', $data->id) }}">
			@method('PUT')
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label for="name">Full Name</label>
										<input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control" placeholder="Full Name">
										<p></p>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="mb-3">
										<label for="email">Email</label>
										<input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control" placeholder="Email">
										<p></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="username">Username</label>
										<input type="text" name="username" id="username" value="{{ $data->username }}" class="form-control" placeholder="Username">
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
