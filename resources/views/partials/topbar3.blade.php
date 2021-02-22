<!-- Topbar Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            {{-- <li class="d-none d-lg-block">
                <form class="app-search">
                    <div class="app-search-box dropdown">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search..." id="top-search">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                        </div>
                       
                    </div>
                </form>
            </li> --}}

          
            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li>

          

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    
                    @if(Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" alt="user-image" class="rounded-circle">
                    @else
                        <img src="{{ asset('images\profile_image\user.png') }}" alt="user-image" class="rounded-circle">
                    @endif

                    <span class="pro-user-name ml-1">
                        {{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{Auth::user()->designation}} </h6>
                    </div>

                    <!-- item-->
                    <a href="{{ url('password/change') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>Password Change</span>
                    </a>

                    {{-- <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>


                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock"></i>
                        <span>Lock Screen</span>
                    </a> --}}

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <form  action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button type="submit"  class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </li>

            <li class="dropdown notification-list">
                {{-- <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a> --}}
            </li>

        </ul>

        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->