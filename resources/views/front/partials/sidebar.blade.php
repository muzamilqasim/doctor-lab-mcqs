<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title d-inline-block mb-0">Profile</h3>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('front.logout') }}" class="btn btn-primary btn-rounded btn-sm">Logout</a>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="bg-light mt-1 rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
        <div class=" align-items-center text-center mb-5">
            <img src="{{ getImage(getFilePath('userProfile') . '/' . user()->image) }}" class="img-fluid img-thumbnail flex-shrink-0 rounded w-50" alt="profile">
            <div>
                <h4 class="mt-3">{{ user()->first_name . ' ' . user()->last_name }}</h4>
            </div>
        </div>
        <div class="mb-5">
            <table width="100%">
                <tr>        
                    <td><h6>Career Stage: </h6></td>
                    <td><h6>{{ user()->careerStage->name ?? 'N/A' }}</h6></td>
                </tr>
                <tr>        
                    <td><h6>Email: </h6></td>
                    <td><h6>{{ user()->email }}</h6></td>
                </tr>
                <tr>        
                    <td><h6>Phone: </h6></td>
                    <td><h6>{{ user()->phone_number ?? 'N/A' }}</h6></td>
                </tr>
            </table>
        </div>
        @php
            $currentRoute = Route::currentRouteName();
        @endphp
        @if($currentRoute === 'front.users.result')
            <a href="{{ route('front.users.profile') }}" class="btn btn-primary mb-2 w-100 p-2 btn-rounded">Dashboard</a>
        @else
            <a href="{{ route('front.users.result') }}" class="btn btn-primary mb-2 w-100 p-2 btn-rounded">Result</a>
        @endif
        @if($currentRoute === 'front.users.history')
            <a href="{{ route('front.users.profile') }}" class="btn btn-primary mb-2 w-100 p-2 btn-rounded">Dashboard</a>
        @else
            <a href="{{ route('front.users.history') }}" class="btn btn-primary mb-2 w-100 p-2 btn-rounded">Plan History</a>
        @endif
            <a href="{{ route('front.users.edit') }}" class="btn btn-primary w-100 p-2 btn-rounded">Update Profile</a>
    </div>
</div>