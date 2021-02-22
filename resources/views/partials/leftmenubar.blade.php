      <!-- ========== Left Sidebar Start ========== -->
      <div class="left-side-menu">

        <div class="h-100" data-simplebar>

            {{-- <!-- User box -->
            <div class="user-box text-center">
                <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                    class="rounded-circle avatar-md">
                <div class="dropdown">
                    <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                        data-toggle="dropdown">Geneva Kennedy</a>
                    <div class="dropdown-menu user-pro-dropdown">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user mr-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings mr-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-lock mr-1"></i>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-log-out mr-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </div>
                <p class="text-muted">Admin Head</p>
            </div> --}}

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">
                    <!-- <li>
                        <a href="{{ url('chats/thread') }}"  class="{{ (request()->is('chats/thread')) ? 'active' : '' }}">
                            <i data-feather="mail"></i>
                            <span> Chats <span class="badge badge-danger">0</span> </span>
                        </a>
                    </li> -->

                    

                    <li class="menu-title">Navigation</li>
                    
                    <li>
                        <a href="{{ url('/') }}" class="{{ (request()->is('/')) ? 'active' : '' }}">
                            <i data-feather="airplay"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    
        
                    
                    @if(Auth::user()->type == 1)

                        <li>
                            <a href="{{ url('/today/tasks') }}" class="{{ (request()->is('/today/tasks')) ? 'active' : '' }}">
                                <i data-feather="trello"></i>
                                <span> Today's Tasks </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/ongoing/tasks') }}" class="{{ (request()->is('/ongoing/tasks')) ? 'active' : '' }}">
                                <i data-feather="aperture"></i>
                                <span> Ongoing Tasks </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ url('/member/accepted/tasks') }}" class="{{ (request()->is('/member/accepted/tasks')) ? 'active' : '' }}">
                                <i data-feather="check-square"></i>
                                <span> Accepted Tasks </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ url('global/task/assign') }}" class="{{ (request()->is('global/task/assign')) ? 'active' : '' }}">
                                <i data-feather="align-left"></i>
                                <span> Global Task Assign </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ url('projects') }}"  class="{{ (request()->is('projects')) ? 'active' : '' }}">
                                <i data-feather="folder-minus"></i>
                                <span> Projects </span>
                            </a>
                        </li>
                        
                         <li>
                            <a href="{{ url('total/completed/project') }}"  class="{{ (request()->is('total/completed/project')) ? 'active' : '' }}">
                                <i data-feather="briefcase"></i>
                                <span> Completed Project </span>
                            </a>
                        </li> 

                        <li>
                            <a href="{{ url('users') }}" class="{{ (request()->is('users')) ? 'active' : '' }}">
                                <i data-feather="users"></i>
                                <span> User </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('employee/workday/list') }}" class="{{ (request()->is('employee/workday/list')) ? 'active' : '' }}">
                                <i data-feather="list"></i>
                                <span> Employee Daily History </span>
                            </a>
                        </li>


                    @else
                    <li>
                        <a href="{{ url('member/tasks') }}"  class="{{ (request()->is('/member/tasks')) ? 'active' : '' }}">
                            <i data-feather="align-left"></i>
                            <span> My Tasks </span>
                        </a>
                    </li> 

                    <li>
                        <a href="{{ url('/member/accepted/tasks') }}" class="{{ (request()->is('/member/accepted/tasks')) ? 'active' : '' }}">
                            <i data-feather="check-square"></i>
                            <span> My Accepted Tasks </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('my/previous/tasks') }}"  class="{{ (request()->is('my/previous/tasks')) ? 'active' : '' }}">
                            <i data-feather="archive"></i>
                            <span> Task Archive </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('my/projects/list') }}"  class="{{ (request()->is('my/projects/list')) ? 'active' : '' }}">
                            <i data-feather="folder-minus"></i>
                            <span> My Project List </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/my/workdays') }}" class="{{ (request()->is('/')) ? 'active' : '' }}">
                            <i data-feather="list"></i>
                            <span> My Work Day </span>
                        </a>
                    </li>

                    

                    @endif

                    <li>
                        <a href="{{ url('notifications/read') }}"  class="{{ (request()->is('notifications/read')) ? 'active' : '' }}">
                            <i data-feather="bell"></i>
                            <span> All Notifications </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('contacts') }}"  class="{{ (request()->is('contacts')) ? 'active' : '' }}">
                            <i data-feather="mail"></i>
                            <span> Contacts </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('about') }}"  class="{{ (request()->is('about')) ? 'active' : '' }}">
                            <i data-feather="info"></i>
                            <span> About </span>
                        </a>
                    </li>
                     

                    
                   

                    

                    
                  

                    
                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->