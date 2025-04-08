@extends('admin.layouts.app')
@section('panel')
<section class="content-header">                    
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('admin.subCategories.index') }}" class="btn btn-outline-dark">Back</a>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="message"></div>
	<div class="container-fluid">
		<form class="saveForm" data-storeURL="{{ route('admin.subCategories.update', $data->id) }}">
			@method('PUT')
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-body">                             
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="category_id">Select Category</label>
										<select name="category_id" id="category_id" class="form-control">
		                                    <option value="">Select Category</option>
		                                    @forelse($categories as $row)
		                                    <option value="{{ $row->id }}" {{ $row->id == $data->category_id ? 'selected' : '' }}>{{ $row->name }}</option>
		                                    @empty
		                                    <option>No Record Found</option>
		                                    @endforelse
		                                </select>
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="title">Sub-Cateogry</label>
										<input type="text" name="title" id="title" value="{{ $data->name }}" class="form-control" placeholder="Category Name">
										<p></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="slug">Slug</label>
										<input type="text" name="slug" id="slug" value="{{ $data->slug }}" class="form-control" placeholder="Slug" readonly>
										<p></p>
									</div>
								</div>
							</div>
						</div>                                                                        
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button type="submit" data-getSlug="{{ route('admin.getSlug') }}" class="btn btn-dark">Update</button>
			</div>
		</form>
	</div>
</section>
@endsection