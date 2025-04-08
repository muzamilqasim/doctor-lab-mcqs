<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if($adminNotificationCount > 0)
                    <span class="badge bg-warning navbar-badge">{{ $adminNotificationCount }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="max-height: 400px; overflow-y: auto;">
                <li>
                    <span class="dropdown-item dropdown-header">
                        {{ $adminNotificationCount > 0 ? $adminNotificationCount : 0 }} Notifications
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>

                @foreach($adminNotifications as $notification)
                    <li>
                        <a href="{{ route('admin.notification.read', $notification->id) }}" class="dropdown-item d-flex align-items-center">
                            <i class="fas fa-envelope me-2"></i>
                            <div class="flex-grow-1">
                                <span class="d-block text-truncate" style="max-width: 250px;">{{ $notification->title }}</span>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                @endforeach 

                <li>
                    <a href="{{ route('admin.notification.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link p-0 pe-3" data-bs-toggle="dropdown" href="#">
                <img src="{{ asset('assets/admin/images/profile.png') }}" class="img-circle elevation-2" width="40" height="40" alt="">
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3">
                <li><h4 class="h4 mb-0"><strong>{{ auth('admin')->user()->name }}</strong></h4></li>
                <li><div class="mb-3">{{ auth('admin')->user()->email }}</div></li>
                <li><hr class="dropdown-divider"></li>

                <li>
                    <a href="{{ route('admin.dashboard.profile') }}" class="dropdown-item {{ menuActive(['admin.dashboard.profile']) }}">
                        <i class="fas fa-cog me-2"></i> Profile Setting
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard.password') }}" class="dropdown-item {{ menuActive(['admin.dashboard.password']) }}">
                        <i class="fas fa-lock me-2"></i> Change Password
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>

                <li>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout                         
                    </a>                            
                </li>
            </ul>
        </li>
    </ul>
</nav>
