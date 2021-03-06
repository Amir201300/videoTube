<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">

                            <img src="{{getAdminImage(Auth::guard('Admin')->user()->photo)}}" alt="users"
                                 class="rounded-circle img-fluid"/>

                        </div>
                        <div class="user-content hide-menu m-t-10">
                            <h5 class="nameOfUser m-b-10 user-name font-medium">{{ Auth::guard('Admin')->user()->name }}</h5>
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd" role="button"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <a href="javascript:void(0)" title="Logout" class="btn btn-circle btn-sm">
                                <i class="ti-power-off"></i>
                            </a>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="{{route('profile.index')}}">
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> تسجيل الخروج</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <!-- main routes section-->
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">الاعدادات الرئيسية</span>
                </li>

                {{--                <li class="sidebar-item">--}}
                {{--                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('admin.dashboard')}}"--}}
                {{--                       aria-expanded="false">--}}
                {{--                        <i class="fa fa-home"></i>--}}
                {{--                        <span class="hide-menu">الصفحة الرئيسية</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}


                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Services.index')}}"
                       aria-expanded="false">
                        <i class="fa fa-caret-square-down"></i>
                        <span class="hide-menu">الخدمات</span>
                    </a>
                </li>


                <!--end main routes section-->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <i class="icon-File-TextImage"></i>
                        <span class="hide-menu"> اعدادات طلبات الخدمات </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Goal.index')}}"
                               aria-expanded="false">
                                <i class="fa fa-caret-square-down"></i>
                                <span class="hide-menu">الاهداف</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Audience.index')}}"
                               aria-expanded="false">
                                <i class="fa fa-caret-square-down"></i>
                                <span class="hide-menu">الجمهور المستهدف</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Sector.index')}}"
                               aria-expanded="false">
                                <i class="fa fa-caret-square-down"></i>
                                <span class="hide-menu">القطاع المستهدف</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Specialty.index')}}"
                               aria-expanded="false">
                                <i class="icon-Add-Bag"></i>
                                <span class="hide-menu">التخصصات</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('VoiceOver.index')}}"
                               aria-expanded="false">
                                <i class="icon-Add-Bag"></i>
                                <span class="hide-menu">التعليقات الصوتية</span>
                            </a>
                        </li>

                    </ul>
                </li>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
