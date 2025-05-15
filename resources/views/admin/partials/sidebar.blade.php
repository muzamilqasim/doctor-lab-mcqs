<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard.index') }}" class="brand-link text-center">
      <span class="brand-text font-weight-light"><b>{{ ($general->site_title) ? $general->site_title : 'Admin Panel' }}</b></span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard.index') }}" class="nav-link {{ menuActive('admin.dashboard.index') }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ menuActive('admin.categories.*') }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.subCategories.index') }}" class="nav-link {{ menuActive('admin.subCategories.*') }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sub Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.questions.index') }}" class="nav-link {{ menuActive('admin.questions.*') }}">
              <i class="nav-icon fas fa-question"></i>
              <p>
                Questions
              </p>
            </a>
          </li>
          @if(auth()->guard('admin')->user()?->hasRole(0))
          <li class="nav-item">
            <a href="{{ route('admin.google_ad.index') }}" class="nav-link {{ menuActive('admin.google_ad.*') }}">
              <i class="nav-icon fas fa-ad"></i>
              <p>
                Google Ad
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('admin.package.index') }}" class="nav-link {{ menuActive('admin.package.*') }}">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Packages
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.careers.index') }}" class="nav-link {{ menuActive('admin.careers.*') }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Career Stage
              </p>
            </a>
          </li>
          @if(auth()->guard('admin')->user()?->hasRole(0))
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ menuActive('admin.users.*') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.managers.index') }}" class="nav-link {{ menuActive('admin.managers.*') }}">
              <i class="nav-icon fas fa-id-badge"></i>
              <p>
                Managers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.users-plan-history.index') }}" class="nav-link {{ menuActive('admin.users-plan-history.*') }}">
              <i class="nav-icon fas fa-history"></i>
              <p>
                Plan History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.home.index') }}" class="nav-link {{ menuActive('admin.home.index') }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home Setting
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.extension.index') }}" class="nav-link {{ menuActive('admin.extension.index') }}">
              <i class="nav-icon fas fa-plug"></i>
              <p>
                Extension
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.setting.index') }}" class="nav-link {{ menuActive('admin.setting.index') }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                General Setting
              </p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </aside>