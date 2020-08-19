<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-container-bg-solid ">
<!-- BEGIN HEADER -->
<?php
    $current_url = $_SERVER['REQUEST_URI'];
    $current_url = explode('?',$current_url);
    $uri = explode('/',$current_url[0]);
    $page = $uri[1];
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{url('dashboard')}}" class="nav-item ajax_item item-1  @if($page=='dashboard') active @endif" data-name="dashboard" data-item="1">
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
                            <img alt="" class="img-circle profile_image" src="{{asset(Session::get('user_photo'))}}">
                        @else
                            <img alt="" class="img-circle profile_image" src="{{asset('assets/layouts/layout/img/emptyuserphoto.jpg')}}">
                        @endif
                        <span class="username username-hide-on-mobile"> {{Session::get('username')}} (ID: {{Session::get('unique_id')}})</span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <li>
                    <a href="{{url('add_user')}}" class="add-new-usre btn btn-danger ajax_item item-3" data-name="add_user" data-item="3">Add New User</a>
                </li>
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <?php
                    $all_notification = \App\Common::getNotifications();
                    $unread_notification = \App\Common::getUnreadNotifications();
                    ?>
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default notification_count @if(count($unread_notification)==0) hidden @endif"> {{(count($unread_notification)>0 ? count($unread_notification) : '')}} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                                <span class="bold">{{(count($unread_notification)>0 ? count($unread_notification) : '')}} pending</span> notifications</h3>
                            <a href="{{url('notifications')}}">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller notification_list" style="height: 250px;" data-handle-color="#637283">
                                @foreach($all_notification as $notification)
                                <li>
                                    <a href="{{url('notifications').'?nid='.$notification->id}}">
                                        <span class="time">{{date('l M d, Y h:i a', strtotime($notification->created_at))}}</span>
                                        <span class="details">
                                            <span class="label label-sm label-icon label-warning">
                                                <i class="icon-bell"></i>
                                            </span>
                                            @if($notification->is_read==0)
                                                <b>{{substr($notification->message, 0, 44)}}</b>
                                            @else
                                                {{substr($notification->message, 0, 44)}}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a href="{{url('message')}}" class="dropdown-toggle">
                        <i class="icon-envelope-open"></i>
                        <span class="badge new_message_count badge-default hidden"> 0 </span>
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

            {{--<li class="nav-item ajax_item item-1  @if($page=='dashboard') active @endif" data-name="dashboard" data-item="1">
                <a href="{{url('dashboard')}}" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>--}}
            <li class="nav-item ajax_item item-2 @if($page=='all_project') active @endif" data-name="all_project" data-item="2">
                <a href="{{url('all_project')}}" class="nav-link">
                    <i class="icon-layers"></i>
                    <span class="title">All Projects</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item ajax_item item-3 @if($page=='user_list') active @endif" data-name="user_list" data-item="3">
                <a href="{{url('user_list')}}" class="nav-link">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item item-4 @if($page=='messages') active @endif" data-name="message" data-item="4">
                <a href="{{url('message')}}" class="nav-link">
                    <i class="icon-envelope"></i>
                    <span class="title">Message</span>
                    <span class="badge new_message_count badge-danger hidden">0</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item ajax_item item-5 @if($page=='profile' || $page=='profile-edit' || $page=='reset-password') active @endif" data-name="profile" data-item="5">
                <a href="{{url('profile')}}" class="nav-link">
                    <i class="icon-user"></i>
                    <span class="title">Profile</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item ajax_item item-6" data-item="6">
                <a href="javascript:;" class="nav-link" data-toggle="modal" data-target="#GuideModal">
                    <i class="icon-book-open"></i>
                    <span class="title">User Guide</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item">
                <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="icon-logout"></i>
                    <span class="title">Log Out</span>
                    <span class="selected"></span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
