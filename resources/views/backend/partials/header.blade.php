<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-1">
            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"
                    class="eva eva-menu-2-outline" fill="#8f9bb3">
                    <g data-name="Layer 2">
                        <g data-name="menu-2">
                            <rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect>
                            <circle cx="4" cy="12" r="1"></circle>
                            <rect x="7" y="11" width="14" height="2" rx=".94" ry=".94"></rect>
                            <rect x="3" y="16" width="18" height="2" rx=".94" ry=".94"></rect>
                            <rect x="3" y="6" width="18" height="2" rx=".94" ry=".94"></rect>
                        </g>
                    </g>
                </svg>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center">
           {{--  <li class="dropdown language_switcher">
                <a class="nav-link dropdown-toggle arrow-none lang-btn" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('default/flag/eng.png') }}" alt="" class="lang-image">
                    <span class="d-lg-block">
                        <h5 class="my-0 fw-normal">
                            <span class="user-profile-name"></span>
                        </h5>
                    </span>
                </a>
            </li> --}}

            <li>
                <div class="nav-link head_notification has_noti">
                    <i class="ri-notification-2-line fs-22"></i>
                </div>
            </li>
            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset(config('constant.default.user_icon')) }}" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-block d-none">
                        <h5 class="my-0 fw-normal">
                            <span class="user-profile-name">Task Management</span> <i
                                class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                        </h5>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">

                    <!-- item-->
                    <a href="" class="dropdown-item">
                        <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                        <span>{{ trans('global.profile') }}</span>
                    </a>

                    <!-- item-->
                    <a href="" class="dropdown-item">
                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                        <span>{{ trans('global.logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
