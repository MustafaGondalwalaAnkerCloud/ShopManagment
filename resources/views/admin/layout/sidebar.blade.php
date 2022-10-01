<div class="app-sidebar menu-fixed" data-background-color="man-of-steel"
    data-image="{{asset('admin/app-assets/img/sidebar-bg/01.jpg')}}" data-scroll-to-active="true">
    <div class="sidebar-header">
        <div class="logo clearfix"><a class="logo-text float-left" href="index-2.html">
                <div class="logo-img"><img src="{{asset('admin/app-assets/img/logo.png')}}" alt="Apex Logo" width="30"
                        height="30" /></div><span class="text">{{ __('Answer99') }}</span>
            </a><a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i
                    class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a><a
                class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i
                    class="ft-x"></i></a></div>
    </div>
    <div class="sidebar-content main-menu-content">
        <div class="nav-container">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }} nav-item"><a
                        href="{{ route('admin.dashboard') }}"><i class="ft-mail"></i><span class="menu-title"
                            data-i18n="Email">Dashboard</span></a>
                </li>

                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-home"></i><span class="menu-title"
                                data-i18n="Dashboard">Admin</span><span
                                class="tag badge badge-pill badge-danger float-right mr-1 mt-1"></span></a>
                    </li>
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-home"></i><span class="menu-title"
                                data-i18n="Category">Category</span><span
                                class="tag badge badge-pill badge-danger float-right mr-1 mt-1"></span></a>
                    </li>
                </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
