
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

<!-- Guide modal START-->
<!-- Modal -->
<div class="modal fade" id="GuideModal" tabindex="-1" role="dialog" aria-labelledby="GuideModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title font-blue-madison bold uppercase" id="GuideModalLabel">User Guide</h4>
            </div>
            <div class="modal-body">
                <h4><b>What is Lorem Ipsum?</b></h4>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

                <h4><b>Why do we use it?</b></h4>
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).


                <h4><b>Where does it come from?</b></h4>
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                <h4><b>Why do we use it?</b></h4>
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).

                <h4><b>Where can I get some?</b></h4>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Guide modal END-->

<input type="hidden" id="refreshed" value="no">


<div class="page-footer">
<div class="page-footer-inner text-center w-100"> © All rights reserved to <a target="_blank" href="https://vujadetec.com/"><strong>vujadetec</strong></a></div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!-- BEGIN FOOTER scripts-->
@include('partials.scripts')
<script>
    $(document).ready(function(){
        //show_content_loader();

        setInterval(function(){
            var id = $('#message_id').val();
            getAndPopulateSelectedMessage(id);
            //getAndShowUnreadMessageCount();
        }, 2000);

        showUserGuide();

    });

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

    /*
            * Load pages through ajax on menu click
            * */
    $(document).on('click','.ajax_item',function(event){
        event.preventDefault();
        var item_number = $(this).attr('data-item');
        $('.ajax_item').removeClass('active');
        $('.nav-item').removeClass('active');
        $(this).addClass('active');
        $('.item-'+item_number).addClass('active');

        var item_name = $(this).attr('data-name');
        if(item_name=='/'){
            var browser_title = 'Home';
        }
        else{
            var browser_title = item_name.replace('_',' ');
            var browser_title = 'Niloy Garments::setti'+browser_title.substr(0,1).toUpperCase()+browser_title.substr(1);
        }
        var uri_string = '/'+item_name;
        if(item_name=='/'){
            var url = "{{url('/')}}";
        }
        else{
            var url = "{{url('/')}}"+uri_string;
        }
        load_new_page_content(url,item_name,browser_title);
    });

    /*
    * Load and populated new page content
    * */
    function load_new_page_content(url,item_name,browser_title){
        $.ajax({
            type: "GET",
            url: url,
            data: {},
            beforeSend: function () {
                show_content_loader();
            },
            success: function (data) {
                HoldOn.close();
                if(data.status == 200){
                    window.history.pushState("data","Title",url);
                    document.title=browser_title;
                    $('.page-content-wrapper').html(data.html);

                    library_re_initialization(item_name);
                }
                else{
                    show_error_message(data.reason);
                    setTimeout(function(){
                        location.reload();
                    },2000)

                }
            },
            error: function (data) {
                show_error_message('Something went wrong. Try again later.');
                setTimeout(function(){
                    location.reload();
                },2000)
            }
        });
    }

    function show_content_loader(){
        var loader_html = '<div class="page-content loader-area">';
        var loader_src = "{{asset('assets/ajax_loader.gif')}}";
        loader_html += '<img title="Loading..." id="loader-gif" class="" style="" src='+loader_src+'>';
        loader_html += '</div>';
        $('.page-content-wrapper').html(loader_html);
    }

    function hide_content_loader(){
        //
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

    function library_re_initialization(item_name){
        adjust_page_height();
        show_notification();
        /*
        * Get and show number of new message
        * */
        //getAndShowUnreadMessageCount();
        /*setInterval(function(){
            var id = $('#message_id').val();
            getAndPopulateSelectedMessage(id);
            //getAndShowUnreadMessageCount();
        }, 2000);*/

        re_initiate_date_picker();
        re_init_phone_velidation();
        renInitTeliphoneValidationForProfile();
        reInitDatepickerForProfile();
        re_initialize_data_table(1);

        var telephone = $('#existing_phone').val();
        if(telephone!==undefined){
            //set_teliphone(telephone);
        }
        if(item_name=='user_list'){
            //
        }
        if(item_name=='message'){
            /*setInterval(function(){
                var id = $('#message_id').val();
                getAndPopulateSelectedMessage(id);
            }, 2000);*/
        }
    }

    function adjust_page_height(){
        var content = $('.page-content');
        var sidebar = $('.page-sidebar');
        var body = $('body');
        var height;


        var headerHeight = $('.page-header').outerHeight();
        var footerHeight = $('.page-footer').outerHeight();


        height = App.getViewPort().height - headerHeight - footerHeight;

        content.attr('style', 'min-height:' + height + 'px');
    }

    function show_notification(){
        var url = "{{ url('get_notifications_ajax') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: {'_token':'{{ csrf_token() }}'},
            success: function (data) {

                if(data.status == 200){
                    var notifications = data.notifications;
                    var unread_notifications = data.unread_notifications.length;
                    if(unread_notifications>0){
                        $('.notification_count').removeClass('hidden');
                        $('.notification_count').text(unread_notifications);
                    }

                    var notification_list = '';
                    $.each(notifications, function( index, notification ) {
                        var edit_url = "{{url('notifications')}}?nid="+notification.id;
                        notification_list +='<li>';
                        notification_list +='<a href="'+edit_url+'">';
                        notification_list +='<span class="time">'+getFormattedDate(notification.created_at,"l M d, Y h:i a")+'</span>';
                        notification_list +='<span class="details">';
                        notification_list +='<span class="label label-sm label-icon label-warning">';
                        notification_list +='<i class="icon-bell"></i>';
                        notification_list +='</span>';
                        if(notification.is_read==0) {
                            notification_list += '<b>'+notification.message+'</b>';
                        }
                        else{
                            notification_list +=notification.message;
                        }
                        notification_list +='</span>';
                        notification_list +='</a>';
                        notification_list +='</li>';
                    });
                    $('.notification_list').html(notification_list);
                }
                else{
                    show_error_message(data.reason);
                    setTimeout(function(){
                        window.location.href="{{url('login')}}";
                    },2000);
                }
            },
            error: function (data) {
                show_error_message(data);
            }
        });
    }

    /*
    * Reloading page on browser back and forth button click
    * */
    $(window).on('popstate', function(event) {
        window.location.reload();
    });

    function renInitTeliphoneValidationForProfile(){
        //Telephone number validation
        var input = document.querySelector("#telephone01");
        if(input != null){
            var iti = window.intlTelInput(input, {
                initialCountry: "bd",
                separateDialCode: true,
                utilsScript: "../assets/global/plugins/intl-tel-input-master/js/utils.js"
            });

            errorMsg = document.querySelector("#error-msg"),
                validMsg = document.querySelector("#valid-msg");

            // here, the index maps to the error code returned from getValidationError - see readme
            var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

            var reset = function() {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                errorMsg.classList.add("hide");
                validMsg.classList.add("hide");
            };

            // on blur: validate
            input.addEventListener('blur', function() {
                reset();

                if (input.value.trim()) {
                    if (iti.isValidNumber()) {
                        validMsg.classList.remove("hide");
                    } else {
                        input.classList.add("error");
                        var errorCode = iti.getValidationError();
                        errorMsg.innerHTML = errorMap[errorCode];
                        errorMsg.classList.remove("hide");
                    }
                }
            });

            // on keyup / change flag: reset
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);

        }
    }

    function reInitDatepickerForProfile(){
        var date = $('#old_shipment_date').val();
        shipping_date =getFormattedDate(date,'m/d/Y');
        $("#ship_date01").datepicker({
            format: 'DD, d M, yyyy',
            autoclose: true
        }).datepicker("update", shipping_date);
    }
</script>
<!-- END FOOTER scripts-->
@yield('js')

@include('partials.js.user.common_js')
@include('partials.js.user.project_js')
@include('partials.js.user.user_js')

</body>

</html>
