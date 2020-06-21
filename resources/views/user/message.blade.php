
@extends('layouts.master')
@section('title', 'Message')
@section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a class=" ajax_item item-1" href="{{url('dashboard')}}" data-name="dashboard" data-item="1">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Message</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title"> Projects
                <small>dashboard &amp; statistics</small>
            </h3> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bubble font-hide hide"></i>
                                <span class="caption-subject font-hide bold uppercase">Chats</span>
                            </div>
                            <div class="actions">
                                <!-- <div class="portlet-input input-inline">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input type="text" class="form-control input-circle" placeholder="search..."> </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="portlet-body" id="chats">
                            <div class="scroller" style="height: 325px;" data-always-visible="1" data-rail-visible1="1">
                                <ul class="chats">
                                    <li class="out">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar2.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Lisa Wong </a>
                                            <span class="datetime"> at 20:11 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="out">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar2.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Lisa Wong </a>
                                            <span class="datetime"> at 20:11 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="in">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar1.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Bob Nilson </a>
                                            <span class="datetime"> at 20:30 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="in">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar1.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Bob Nilson </a>
                                            <span class="datetime"> at 20:30 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="out">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar3.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Richard Doe </a>
                                            <span class="datetime"> at 20:33 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="in">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar3.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Richard Doe </a>
                                            <span class="datetime"> at 20:35 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="out">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar1.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Bob Nilson </a>
                                            <span class="datetime"> at 20:40 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="in">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar3.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Richard Doe </a>
                                            <span class="datetime"> at 20:40 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </li>
                                    <li class="out">
                                        <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/avatar1.jpg')}}" />
                                        <div class="message">
                                            <span class="arrow"> </span>
                                            <a href="javascript:;" class="name"> Bob Nilson </a>
                                            <span class="datetime"> at 20:54 </span>
                                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet. </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="chat-form">
                                <div class="input-cont">
                                    <input class="form-control" type="text" placeholder="Type a message here..." /> </div>
                                <div class="btn-cont">
                                    <span class="arrow"> </span>
                                    <a href="" class="btn blue icn-only">
                                        <i class="icon-paper-plane icons"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>

    </script>
@endsection

