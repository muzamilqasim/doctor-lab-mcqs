@extends('admin.layouts.app')

@section('panel')
<section class="content-header">                    
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('admin.package.index') }}" class="btn btn-outline-dark">Back</a>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="message"></div>
	<div class="container-fluid">
		<form class="saveForm" data-storeURL="{{ route('admin.package.update', $data->id) }}">
			@method('PUT')
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<!-- Title Field -->
								<div class="col-md-12">
									<div class="mb-3">
										<label for="title">Title</label>
										<input type="text" name="title" id="title" value="{{ old('title', $data->title) }}" class="form-control" placeholder="Title" required>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="duration">Duration (Days)</label>
										<input type="number" name="duration" id="duration" value="{{ old('duration', $data->duration) }}" class="form-control" placeholder="Enter duration in days" required min="1">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="price">Price ($)</label>
										<input type="number" name="price" id="price" value="{{ old('price', $data->price) }}" class="form-control" placeholder="Enter price" required min="0" step="0.01">
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
