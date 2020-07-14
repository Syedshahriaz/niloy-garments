
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
                            <div id="char_user_list" class="inbox">
                                <ul class="inbox-contacts">
                                    <li class="active">
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar2.jpg')}}">
                                            <span class="contact-name">Adam Stone</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar3.jpg')}}">
                                            <span class="contact-name">Lisa Wong</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar4.jpg')}}">
                                            <span class="contact-name">Nick Strong</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar6.jpg')}}">
                                            <span class="contact-name">Anna Bold</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar7.jpg')}}">
                                            <span class="contact-name">Richard Nilson</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div id="char_body">
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
                                    <form id="message_form" method="post" action="" enctype="multipart/form-data">
                                        <div class="input-cont">
                                            <input class="form-control" name="message" id="message_input" type="text" placeholder="Type a message here..." />
                                            <input class="hidden" type="file" name="message_file" id="image_upload_input">
                                            <img id="uploaded_img" src="" class="">
                                            <div class="" id="upload_btn">
                                                <i class="icon-paper-clip icons"></i>
                                            </div>
                                        </div>
                                        <div class="btn-cont">
                                            <span class="arrow"> </span>
                                            <a href="javascript:void(0)" class="btn blue icn-only" id="send_btn">
                                                <i class="icon-paper-plane icons"></i>
                                            </a>
                                        </div>
                                    </form>

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
        jQuery(document).ready(function() {

            var cont = $('#chats');
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('input', form);
            var btn = $('#sent_btn', form);

            var handleClick = function(e) {
                e.preventDefault();
                $('#uploaded_img').removeClass('visible');
                $('#message_input').removeClass('img-added');

                var text = input.val();
                if (text.length == 0) {
                    return;
                }

                var time = new Date();
                var time_str = (time.getHours() + ':' + time.getMinutes());
                var tpl = '';
                tpl += '<li class="out">';
                tpl += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + 'avatar1.jpg"/>';
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">Bob Nilson</a>&nbsp;';
                tpl += '<span class="datetime">at ' + time_str + '</span>';
                tpl += '<span class="body">';
                tpl += text;
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</li>';

                var msg = list.append(tpl);
                input.val("");

                var getLastPostPos = function() {
                    var height = 0;
                    cont.find("li.out, li.in").each(function() {
                        height = height + $(this).outerHeight();
                    });

                    return height;
                }

                cont.find('.scroller').slimScroll({
                    scrollTo: getLastPostPos()
                });
            }

            $('body').on('click', '.message .name', function(e) {
                e.preventDefault(); // prevent click event

                var name = $(this).text(); // get clicked user's full name
                input.val('@' + name + ':'); // set it into the input field
                App.scrollTo(input); // scroll to input if needed
            });

            btn.click(handleClick);

            input.keypress(function(e) {
                if (e.which == 13) {
                    handleClick(e);
                    return false;
                }
            });

            //image upload
            $(document).on('click','#upload_btn', function(e){
                e.preventDefault();
                $('#image_upload_input').click();
            });

            $("#image_upload_input").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#uploaded_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                    $('#message_input').addClass('img-added')
                    $('#uploaded_img').addClass('visible')
                }
            }
        });
    </script>
@endsection

