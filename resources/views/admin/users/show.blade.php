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
	<div class="container-fluid">
		<div class="message"></div>
		<div class="row">
			<div class="col-md-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}" alt="profile picture">
						</div>
						<h3 class="profile-username text-center">{{ $user->first_name . ' ' . $user->last_name }}</h3>
						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Email</b> <a href="#" class="float-right">{{ $user->email }}</a>
							</li>
							<li class="list-group-item">
								<b>Phone#</b> <span class="float-right">{{ $user->phone_number ?? 'N/A' }}</span>
							</li>
							<li class="list-group-item">
								<b>Career Stage</b> <span class="float-right">{{ $user->careerStage->name ?? 'N/A' }}</span>
							</li>
							<li class="list-group-item">
								<b>Google Login</b> 
								<span class="float-right">{{ ($user->google_login == 1) ? 'Yes' : 'No' }}</span>
							</li>
							<li class="list-group-item">
								<b>Last Login</b> 
								<span class="float-right">{{ $user->last_login ? diffForHumans($user->last_login) : 'N/A' }}</span>
							</li>
							<li class="list-group-item">
								<b>Last IP</b> <span class="float-right">{{ $user->last_ip ?? 'N/A' }}</span>
							</li>
							<li class="list-group-item">
								<b>Status</b> 
								@if($user->status == "Active")
								<span class="badge badge-success float-right">Active</span>
								@else
								<span class="badge badge-danger float-right">Inactive</span>
								@endif
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="card mt-3">
							    <div class="card-body">
							        <h5 class="card-title"><b>Subscription Details</b></h5>
							        @if($subscription)
							            <ul class="list-group list-group-flush">
							                <li class="list-group-item">
							                    <strong>Package:</strong> {{ $subscription->package->title }}
							                </li>
							                <li class="list-group-item">
							                    <strong>Price:</strong> ${{ $subscription->package->price }}
							                </li>
							                <li class="list-group-item">
							                    <strong>Total Days:</strong> {{ $subscription->package->duration }} days
							                </li>
							                <li class="list-group-item">
							                    <strong>Remaining Days:</strong> 
							                    @if($remainingDays > 0)
							                        <span class="text-success">{{ $remainingDays }} days left</span>
							                    @else
							                        <span class="text-danger">Expired</span>
							                    @endif
							                </li>
							                <li class="list-group-item">
							                    <strong>Status:</strong> 
							                    <span class="badge {{ $subscription->status === 'active' ? 'badge-success' : 'badge-danger' }}">
							                        {{ ucfirst($subscription->status) }}
							                    </span>
							                </li>
							            </ul>
							        @else
							           <br> <p class="text-muted">No active subscription.</p>
							        @endif
							    </div>
							</div>

							<div class="col-lg-12">
								<div class="accordion" id="testResultsAccordion">
									@foreach($testResults as $index => $result)
									<div class="card shadow-sm mb-3">
										<div class="card-header" id="heading{{ $index }}">
											<h5 class="mb-0">
												<button class="btn btn-link text-decoration-none w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
													<span class="text-primary">{{ $result->question->title }}</span>
												</button>
											</h5>
										</div>
										<div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#testResultsAccordion">
											<div class="card-body">
												<p class="card-text text-dark">{{ $result->question->question_text }}</p>

												@php
												$selectedOption = $result->question->options->where('id', $result->answer)->first();
												$correctOption = $result->question->options->where('is_correct', 'true')->first();
												$explanation = $result->question->explanation;
												@endphp

												<p>
													Your Answer: 
													<span class="fw-bold {{ $result->is_correct == 'true' ? 'text-success' : 'text-danger' }}">
														{{ $result->is_correct == 'true' ? 'Correct' : 'Incorrect' }}
													</span>
												</p>

												<p>
													Selected Option: 
													<span class="fw-bold text-dark">
														{{ $selectedOption ? $selectedOption->option_text : 'Not Available' }}
													</span>
												</p>

												<p>
													Correct Answer: 
													<span class="fw-bold text-primary">
														{{ $correctOption ? $correctOption->option_text : 'Not Available' }}
													</span>
												</p>

												<p>
													Explanation: 
													<span class="text-muted">
														{!! $explanation ? $explanation->description : 'No explanation provided' !!}
													</span>
												</p>

											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>                                                              
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
