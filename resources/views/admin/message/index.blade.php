
@extends('layouts.admin_master')
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
                                    @if(count($messages) !=0)
                                        @foreach($messages as $key=>$message)
                                        <li class="message_head @if($key==0)active @endif" data-id="{{$message->id}}">
                                            <a href="javascript:;">
                                                @if($message->user_photo !='')
                                                    <img class="contact-pic" alt="" src="{{asset($message->user_photo)}}" />
                                                @else
                                                    <img class="contact-pic" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" />
                                                @endif
                                                <span class="contact-name">{{$message->user_name}}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div id="char_body">
                                <div class="scroller" style="height: 325px;" data-always-visible="1" data-rail-visible1="1">
                                    <ul class="chats">
                                        @if(!empty($last_message))
                                            @foreach($last_message->message_details as $m_details)
                                                @if($m_details->type=='received')
                                                    <li class="out">
                                                        @if($last_message->admin_photo !='')
                                                            <img class="avatar" alt="" src="{{asset($last_message->admin_photo)}}" />
                                                        @else
                                                            <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" />
                                                        @endif
                                                        <div class="message">
                                                            <span class="arrow"> </span>
                                                            <a href="javascript:;" class="name"> {{$last_message->admin_name}} </a>
                                                            <span class="datetime"> at {{date('d/m/Y h:i a',strtotime($m_details->created_at))}}</span>
                                                            <span class="body">
                                                                @if($m_details->file_path !='')
                                                                    <img style="width: 330px;" class="body" src="{{asset($m_details->file_path)}}">
                                                                @endif
                                                                @if($m_details->message !='')
                                                                    {{$m_details->message}}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="in">
                                                        @if($last_message->user_photo !='')
                                                            <img class="avatar" alt="" src="{{asset($last_message->user_photo)}}" />
                                                        @else
                                                            <img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" />
                                                        @endif
                                                        <div class="message">
                                                            <span class="arrow"> </span>
                                                            <a href="javascript:;" class="name"> {{$last_message->user_name}} </a>
                                                            <span class="datetime"> at {{date('d/m/Y h:i a',strtotime($m_details->created_at))}}</span>
                                                            <span class="body">
                                                                @if($m_details->file_path !='')
                                                                    <span>
                                                                        <img style="float: right;width: 330px;" class="body" src="{{asset($m_details->file_path)}}">
                                                                    </span>
                                                                @endif
                                                                @if($m_details->message !='')
                                                                    <p style="clear: both">
                                                                    {{$m_details->message}}
                                                                    </p>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <form id="message_form" method="post" action="" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="user_id" id="user_id" value="@if(!empty($last_message)){{$last_message->user_id}}@endif">
                                    <input type="hidden" name="message_id" id="message_id" value="@if(!empty($last_message)){{$last_message->id}}@endif">
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
        jQuery(document).ready(function() {

            setInterval(function(){
                var id = $('#message_id').val();
                getAndPopulateSelectedMessage(id);
            }, 2000);

            var getLastPostPos = function() {
                var height = 0;
                cont.find("li.out, li.in").each(function() {
                    height = height + $(this).outerHeight();
                });

                return height;
            }

            var cont = $('#chats');

            cont.find('.scroller').slimScroll({
                scrollTo: getLastPostPos()
            });

            /*var cont = $('#chats');
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
            });*/

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

        $(document).on('submit','#message_form', function(){
            submit_message();
        });

        $(document).on('click','#send_btn', function(){
            submit_message();
        });

        function submit_message(){
            event.preventDefault();

            var user_id = $("#user_id").val();
            var message = $("#message_input").val();
            var message_file = $("#image_upload_input").val();

            var validate = "";

            if (message.trim() == "" && message_file=='') {
                return false;
            }

            if (validate == "") {
                var formData = new FormData($("#message_form")[0]);
                var url = "{{ url('admin/store_message') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        if (data.status == 200) {
                            appendMessage(message,data.photo_path);
                        } else {
                            $("#success_message").hide();
                            $("#error_message").show();
                            $("#error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        }

        function getFormattedDate(date){
            var time = new Date(date);
            var d = time.getDate();
            var m =  time.getMonth();
            m += 1;  // JavaScript months are 0-11
            var y = time.getFullYear();
            var hours = time.getHours();
            var minutes = time.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;

            var time_str = (d + '/' + m + '/' + y + ' ' + hours + ':' + minutes +' '+ampm);

            return time_str;
        }

        $(document).on('click','.message_head', function(){
            $('.message_head').removeClass('active');
            $(this).addClass('active');

            var id = $(this).attr('data-id');
            getAndPopulateSelectedMessage(id);
        });

        function getAndPopulateSelectedMessage(id){
            var url = "{{ url('admin/get_message_details') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: {message_id:id,'_token':'{{ csrf_token() }}'},
                success: function(data) {
                    if (data.status == 200) {
                        populateMessage(data.message);
                    } else {
                        //Nothing to do now;
                    }
                },
                error: function(data) {
                    //Nothing to do now;
                }
            });
        }

        function appendMessage(message,photo_path) {
            var cont = $('#chats');
            var list = $('.chats', cont);
            var user_name = $('#user_name').val();

            $('#uploaded_img').removeClass('visible');
            $('#message_input').removeClass('img-added');

            var time = new Date();
            var time_str = getFormattedDate(time);

            var profile_photo = "{{Session::get('user_photo')}}";

            var tpl = '';
            tpl += '<li class="out">';
            if(profile_photo !=''){
                tpl += '<img class="avatar" alt="" src="{{asset(Session::get('user_photo'))}}"/>';
            }
            else{
                tpl += '<img class="avatar" alt="" src="http://127.0.0.1:8000/assets/layouts/layout/img/emptyuserphoto.png"/>';
            }
            tpl += '<div class="message">';
            tpl += '<span class="arrow"></span>';
            tpl += '<a href="#" class="name">{{Session::get('username')}}</a>&nbsp;';
            tpl += '<span class="datetime">at ' + time_str + '</span>';
            tpl += '<span class="body">';
            if(photo_path !=''){
                var file_path = "{{url('/')}}/"+photo_path;
                tpl += '<img style="float: right;width: 330px;" class="body" src="'+file_path+'">';
            }
            if(message !='') {
                tpl += '<p style="clear: both">' + message + '</p>';
            }
            tpl += '</span>';
            tpl += '</div>';
            tpl += '</li>';

            var msg = list.append(tpl);
            $('#message_input').val("");

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

        function populateMessage(message) {
            var cont = $('#chats');
            var list = $('.chats', cont);

            $('#user_id').val(message.user_id);
            $('#message_id').val(message.id);

            var tpl = '';

            $.each(message.message_details, function( index, msg ) {

                var time_str = getFormattedDate(msg.created_at);

                if(msg.type=='sent'){
                    var message_type = 'in';
                    var profile_photo = message.user_photo;
                    var user_name = message.user_name;
                }
                else{
                    var message_type = 'out';
                    var profile_photo = message.admin_photo;
                    var user_name = message.admin_name;
                }

                var photo_path = msg.file_path;

                tpl += '<li class="'+message_type+'">';
                if (profile_photo != null) {
                    var profile_photo_path = "{{url('/')}}/" + profile_photo;
                    tpl += '<img class="avatar" alt="" src="'+profile_photo_path+'"/>';
                } else {
                    tpl += '<img class="avatar" alt="" src="{{url('/')}}/assets/layouts/layout/img/emptyuserphoto.png"/>';
                }
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">'+user_name+'</a>&nbsp;';
                tpl += '<span class="datetime">at ' + time_str + '</span>';
                tpl += '<span class="body">';
                if (photo_path != null) {
                    var file_path = "{{url('/')}}/" + photo_path;
                    tpl += '<img style="float: right;width: 330px;" class="body" src="' + file_path + '">';
                }
                if(msg.message !==null) {
                    tpl += '<p style="clear: both">' + msg.message + '</p>';
                }
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</li>';
            });

            var msg = list.html(tpl);

            var getLastPostPos = function() {
                var height = 0;
                cont.find("li.out, li.in").each(function() {
                    height = height + $(this).outerHeight();
                });

                return height;
            }

            /*cont.find('.scroller').slimScroll({
                scrollTo: getLastPostPos()
            });*/
        }
    </script>
@endsection

