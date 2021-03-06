
</div>
<!-- END CONTAINER -->


<div class="modal fade global-warning error" id="warning_modal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <!-- <button data-dismiss="modal" aria-label="Close" class="btn btn-xs btn-default btn-circle btn-close">&times;</button> -->
            <div class="modal-body text-center">
                <i class="fa fa-info-circle text-danger fa-3x"></i>
                <p class="warning_message"> Are you sure you want to delete this record? </p>
                <input type="hidden" id="item_id">
                <input type="hidden" id="item_type">
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-light">No</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary target"  id="warning_ok">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- alert message START -->
<div class="modal fade alert global-warning" role="dialog" id="alert-modal" style="z-index: 99999">
    <div class="modal-dialog modal-sm modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="alert-error-msg">
                    <i class="fa fa-exclamation-triangle fa-3x text-danger"></i> <br>  <br>
                    <p class="text-danger"></p>
                </div>

                <div id="alert-success-msg">
                    <i class="fa fa-check-circle text-success fa-3x"></i>
                    <p class="text-success"></p>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" id="alert-ok">ok</button>
            </div>
        </div>

    </div>
</div>
<!-- alert message End -->

<div class="page-footer">
<div class="page-footer-inner text-center w-100"> © All rights reserved to <a target="_blank" href="https://vujadetec.com/"><strong>vujadetec</strong></a></div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<input id="unread_message" value="{{App\Common::getUnreadMessageCount()}}">
<audio id="audio" src="{{asset('assets/message_sound.mp3')}}"></audio>

<!-- BEGIN FOOTER scripts-->
@include('partials.admin.scripts')
<!-- END FOOTER scripts-->
<script>
    $(document).ready(function(){

        setInterval(function(){
            var id = $('#message_id').val();
            getAndPopulateSelectedMessage(id);
            getAndShowUnreadMessageCount();
        }, 2000);
    })

    function show_success_message($message){
        $('#alert-modal').modal('show');
        $('#alert-error-msg').hide();
        $('#alert-success-msg').show();
        $('#alert-success-msg p').html($message);
    }
    function show_error_message(message){
        $('#alert-modal').modal('show');
        $('#alert-error-msg').show();
        $('#alert-success-msg').hide();
        $('#alert-error-msg p').html(message);
    }

    function show_loader(message=''){
        if(message==''){
            message = 'Please wait while saving all data.....'; // Showing default message
        }
        var options = {
            theme: "sk-cube-grid",
            message: message,
            backgroundColor: "#1847B1",
            textColor: "white"
        };

        HoldOn.open(options);
    }

    function hide_loader(){
        HoldOn.close();
    }

    function getAndShowUnreadMessageCount(){
        var url = "{{url('admin/get_unread_message') }}";

        $.ajax({
            type: "POST",
            url: url,
            data: {'_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data) {
                if (data.status == 200) {
                    var browser_title = document.title;
                    browser_title = browser_title.replace(/ *\([^)]*\) */g, "");

                    var message_count = data.messages.length;
                    if(message_count>0){
                        var previous_unread_message = $('#unread_message').val();
                        $('.new_message_count').removeClass('hidden');
                        $('.new_message_count').text(message_count);
                        document.title=browser_title+"("+message_count+")"; // Set browser title;

                        /*Play message tone*/
                        if(message_count>previous_unread_message){
                            document.getElementById("audio").play();
                            $('#unread_message').val(message_count);
                        }
                    }
                    else{
                        $('.new_message_count').addClass('hidden');
                        document.title=browser_title; // Set browser title;
                    }
                } else {
                    //Nothing to do now;
                }
            },
            error: function(data) {
                //Nothing to do now;
            }
        });
    }

    function getAndPopulateSelectedMessage(id){
        var url = "{{ url('admin/get_message_details') }}";

        $.ajax({
            type: "POST",
            url: url,
            data: {message_id:id,'_token':'{{ csrf_token() }}'},
            success: function(data) {
                var keyword = $('#search-box').val();
                var current_message_id = $('#message_id').val();

                if (data.status == 200) {
                    if(id==current_message_id){
                        populateMessage(data.message);
                    }
                    if(keyword =='') {
                        populateMessageHead(data.message_heads);
                    }
                } else {
                    //Nothing to do now;
                }
            },
            error: function(data) {
                //Nothing to do now;
            }
        });
    }

    function populateMessageHead(message_heads){
        var active_message = $('#message_id').val();
        $message_heads = '';
        $.each(message_heads, function( index, msg ) {
            var active_class='';
            if(msg.user_photo !=null){
                var photo_url = "{{url('/')}}/"+msg.user_photo;
            }
            else{
                var photo_url = "{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}";
            }
            if(msg.id==active_message){
                active_class='active';
            }

            $message_heads +='<li class="message_head '+active_class+' " data-id="'+msg.id+'">';
            $message_heads +='<a href="javascript:;">';
            $message_heads +='<img class="contact-pic" alt="" src="'+photo_url+'">'
            $message_heads +='<span class="contact-name">'+msg.user_name+'</span>';
            if(msg.has_new_message==1){
                $message_heads += '<img style="width:15px;float: right;" class="action-icon" src="{{asset('assets/global/img/icons/new_message.png')}}" alt="New Message">';
            }
            $message_heads +='</a>';
            $message_heads +='</li>';
        });
        $('.inbox-contacts').html($message_heads);
    }

    function populateMessage(message) {
        var cont = $('#chats');
        var list = $('.chats', cont);

        /*$('#user_id').val(message.user_id);
        $('#message_id').val(message.id);*/

        var tpl = '';

        $.each(message.message_details, function( index, msg ) {

            var time_str = getFormattedDate(msg.created_at,'l M d, Y h:i a');

            if(msg.type=='sent'){
                var message_type = 'in';
                var profile_photo = message.user_photo;
                var user_name = message.user_name;
                var user_dashboard_link = "{{url('admin/user_dashboard')}}?u_id="+message.user_id;
            }
            else{
                var message_type = 'out';
                var profile_photo = message.admin_photo;
                var user_name = 'Vujadetec';
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
            tpl += '<a href="'+user_dashboard_link+'" class="name">'+user_name+'</a>&nbsp;';
            tpl += '<span class="datetime">at ' + time_str + '</span>';
            tpl += '<p class="body">';
            if (photo_path != null) {
                var file_path = "{{url('/')}}/" + photo_path;
                tpl += '<img style="float: right; max-width: 200px;" class="body" src="' + file_path + '">';
            }
            if(msg.message !==null) {
                tpl += '<span style="clear: both">' + msg.message + '</span>';
            }
            tpl += '</p>';
            tpl += '</div>';
            tpl += '</li>';
        });

        var msg = list.html(tpl);

        hide_loader();

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

    function getFormattedDate(original_date,format=''){
        const dayNames = ["Sunday","Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
            "Saturday",
        ];
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        original_date = original_date.replace(' ', 'T');
        var formattedDate = new Date(original_date);

        var d = formattedDate.getDate();
        var day = formattedDate.getDay();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        var hours = formattedDate.getHours();
        var minutes = formattedDate.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;

        if(original_date=='' || original_date===null){
            return '';
        }
        if(format==''){
            return (d + '/' + m + '/' + y + ' ' + hours + ':' + minutes +' '+ampm);
        }
        else if(format=='m/d/Y'){
            if(d<10){
                d = '0'+d;
            }
            m = m+1;
            if(m<10){
                m = '0'+m;
            }
            return m + "/" + d + "/" + y;
        }
        else if(format=='d/m/Y'){
            if(d<10){
                d = '0'+d;
            }
            m = m+1;
            if(m<10){
                m = '0'+m;
            }
            return d + "/" + m + "/" +  y;
        }
        else if(format=='M d'){
            return monthNames[m] + " " + d;
        }
        else if(format=='M-d-y'){
            return monthNames[m] + "-" + d + "-" + y;
        }
        else if(format=='l M d, Y h:i a'){
            return (dayNames[day] + ' ' + monthNames[(m-1)] + ' ' + d +', ' + y + ' ' + hours + ':' + minutes +' '+ampm);
        }
        else{
            return monthNames[m] + " " + d + ", " + y;
        }
    }

</script>
@yield('js')

@include('partials.js.user.common_js')
</body>

</html>
