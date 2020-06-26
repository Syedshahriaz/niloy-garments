<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-container-bg-solid ">
<!-- BEGIN HEADER -->
<?php
    $current_url = $_SERVER['REQUEST_URI'];
    $current_url = explode('?',$current_url);
    $uri = explode('/',$current_url[0]);
    $page = $uri[2];
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img src="{{asset('assets/layouts/layout/img/logo.png')}}" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-left">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle">
                        @if(Session::get('user_photo') !='')
                            <img alt="" class="img-circle" src="{{asset(Session::get('user_photo'))}}">
                        @else
                            <img alt="" class="img-circle" src="{{asset('assets/layouts/layout/img/emptyuserphoto.jpg')}}">
                        @endif
                        <span class="username username-hide-on-mobile"> {{Session::get('username')}}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">

                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-envelope-open"></i>
                        <span class="badge badge-default"> 4 </span>
                    </a>
                </li>
                <!-- END INBOX DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">

<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                    <span></span>
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>

            <!-- <li class="nav-item  @if($page=='dashboard') active @endif">
                <a href="#" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if($page=='all_project') active @endif">
                <a href="#" class="nav-link">
                    <i class="icon-layers"></i>
                    <span class="title">All Projects</span>
                    <span class="selected"></span>
                </a>
            </li> -->

            <li class="nav-item @if($page=='users') active @endif">
                <a href="{{url('admin/users')}}" class="nav-link">
                    <i class="icon-users"></i>
                    <span class="title">All Users</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if($page=='messages') active @endif">
                <a href="#" class="nav-link">
                    <i class="icon-envelope"></i>
                    <span class="title">Massage</span>
                    <span class="badge badge-danger">2</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if($page=='settings') active @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Settings</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li class="nav-item start ">
                        <a href="{{url('admin/promotion')}}" class="nav-link">
                            <span class="title">Promotio Page</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{url('#')}}" class="nav-link">
                            <span class="title">Project & Tasks</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{url('admin/settings')}}" class="nav-link">
                            <span class="title">Common</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a  href="{{ url('admin/logout') }}" class="nav-link">
                    <i class="icon-logout"></i>
                    <span class="title">Log Out</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
