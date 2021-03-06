
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
                        <a class=" item-1" href="https://vujadetec.com" target="_blank" data-name="dashboard" data-item="1">Home</a>
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
                            {{--<div id="char_user_list" class="inbox">
                                <ul class="inbox-contacts">
                                    <li class="active">
                                        <a href="javascript:;">
                                            <img class="contact-pic" src="{{asset('assets/layouts/layout/img/avatar2.jpg')}}">
                                            <span class="contact-name">Adam Stone</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>--}}

                            <div id="char_body">
                                <div>
                                    <ul class="chats">
                                        @if(!empty($message))
                                            @foreach($message->message_details as $m_details)
                                                @if($m_details->type=='received')
                                                    <li class="in">
                                                        @if($message->admin_photo !='')
                                                            <img class="avatar" alt="" src="{{asset($message->admin_photo)}}" />
                                                        @else
                                                            <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" />
                                                        @endif
                                                        <div class="message">
                                                            <span class="arrow"> </span>
                                                            <a href="javascript:;" class="name"> Vujadetec </a>
                                                            <span class="datetime"> at {{date('l M d, Y h:i a',strtotime($m_details->created_at))}}</span>
                                                            <p class="body">
                                                                @if($m_details->file_path !='')
                                                                    <img style="max-width: 20px;" class="body" src="{{asset($m_details->file_path)}}">
                                                                @endif
                                                                @if($m_details->message !='')
                                                                    {{$m_details->message}}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="out">
                                                        @if($message->user_photo !='')
                                                            <img class="avatar" alt="" src="{{asset($message->user_photo)}}" />
                                                        @else
                                                            <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" />
                                                        @endif
                                                        <div class="message">
                                                            <span class="arrow"> </span>
                                                            <a href="javascript:;" class="name"> {{$message->user_name}} </a>
                                                            <span class="datetime"> at {{date('l M d, Y h:i a',strtotime($m_details->created_at))}}</span>
                                                            <p class="body">
                                                                @if($m_details->file_path !='')
                                                                    <span>
                                                                        <img style="float: right; max-width: 200px;" class="body" src="{{asset($m_details->file_path)}}">
                                                                    </span>
                                                                @endif
                                                                @if($m_details->message !='')
                                                                    <span style="clear: both">
                                                                    {{$m_details->message}}
                                                                    </span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <form id="message_form" method="post" action="" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                                    <input type="hidden" name="message_id" id="message_id" value="@if(!empty($message)){{$message->id}}@endif">
                                    <input type="hidden" name="user_name" id="user_name" value="{{$user->username}}">
                                    <div class="chat-form">
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
                                    </div>
                                </form>
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
        //message FE script START 
        function scrollBottom(){
            $('#char_body>div').stop().animate({
                scrollTop: $('#char_body>div')[0].scrollHeight
            });
        }
        $(document).ready(function(){
            setTimeout(() => {
                scrollBottom();
            }, 1000);
        })
        $(document).on('click','#send_btn',function(e){
            e.preventDefault();
            e.stopPropagation();
            if($('#uploaded_img').attr('src') == ''){
                setTimeout(() => {
                    scrollBottom();
                }, 1500);
            }
            else{
                setTimeout(() => {
                    scrollBottom();
                }, 5000);
            }
        });

        $('#message_input').on('keypress', function (e) {
            if(e.which === 13){

                if($('#uploaded_img').attr('src') == ''){
                    setTimeout(() => {
                        scrollBottom();
                    }, 1500);
                }
                else{
                    setTimeout(() => {
                        //alert();
                        scrollBottom();
                    }, 5000);
                }
            }
        });
        //message FE script END

        jQuery(document).ready(function() {

            /*
            * Get and show number of new message
            * */
            //getAndShowUnreadMessageCount();

            setInterval(function(){
                var id = $('#message_id').val();
                getAndPopulateSelectedMessage(id);
            }, 1000);

            //message bosy height
            if($(window).width() > 991){
                var content_height = $('.page-content').css('min-height');
                content_height = parseInt(content_height.slice(0, -2));
                var chat_height = parseInt(content_height - 275);
                $('#char_body>div').css('max-height', chat_height + 'px');
            }
            else{
                var sm_height = parseInt($(window).width() - 100);
                $('#char_body>div').css('max-height', sm_height + 'px');
            }

            // var getLastPostPos = function() {
            //     var height = 0;
            //     cont.find("li.out, li.in").each(function() {
            //         height = height + $(this).outerHeight();
            //     });

            //     return height;
            // }

            // var cont = $('#chats');

            // cont.find('.scroller').slimScroll({
            //     scrollTo: getLastPostPos()
            // });

            //image upload
            $(document).on('click','#upload_btn', function(e){
                e.preventDefault();
                $('#image_upload_input').click();
            });

            $(document).on('change','#image_upload_input', function(e){
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

