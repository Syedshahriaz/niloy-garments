
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
                <h4 class="modal-title bold text-white uppercase " id="GuideModalLabel">User Guide</h4>
            </div>
            <div class="modal-body">
                <span style="background-color:black; color:white;">&nbsp; Vujade<span style="color:#bf945b;">tec&nbsp;</span></span> offers 3 offer <span style="background-color:#599a13; color:white;">&nbsp;Green&nbsp;</span>-<span style="background-color:#d61919;; color:white;">&nbsp;Red&nbsp;</span>-<span style="background-color:#fc0aa6">&nbsp;Pink&nbsp;</span>. These 3 offer cover all age, all gender including pregnant women &amp; females. It is also for those who are taking regular vaccines OR who are not taking regular vaccines OR missed the vaccines. So anyone can start the vaccine from today. <span style="background-color:#fc0aa6">&nbsp;Pink&nbsp;</span> offers are complimentary for females if you buy any one offer from <span style="background-color:#599a13; color:white;">&nbsp;Green&nbsp;</span> or <span style="background-color:#d61919;; color:white;">&nbsp;Red&nbsp;</span> 
                <br><br>
                <span style="background-color:#599a13; color:white;">GREEN OFFER:</span> This offer is for newborn to Life time (100+ years). Please<span> choose</span> this offer for your baby who are regularly taking the vaccine from newborn to till today. You still can buy this if your baby missed a few vaccines but your baby age is under 18 months. 
                There is an option to change your offer without extra charge from GREEN to RED if you mistakenly choose the Green offer instead of Red offer. 
                <br><br>
                <span style="background-color:#d61919;; color:white;">&nbsp;RED OFFER:&nbsp;</span> This offer is for those who missed the vaccine multiple times or who do not have a record. The recommended age group starts from 2 years to Life time (100+ years). Preteens, Teens, Adults across all gender fall under this category. 
                There is an option to change your offer without extra charge from RED to GREEN if you mistakenly choose RED offer instead of Green offer. <br>
                If you choose Red offfer, the system will give you reminder only for those dose which are required based on your age and gender. Therefore some dose will keep locked which is not required for you.
                <br><br>
                <span style="background-color:#fc0aa6">&nbsp;PINK OFFER&nbsp;</span>=FREE: This offer is free for females who have already purchased from above 2 offers. System will give you reminders of required vaccines automatically if you put a date of pregnancy. Female Teen Child who are age 15+ also will get a reminder of vaccine automatically. 
                <br><br>
                How to use:
                <br><br>
                <ul>
                1.	Correct date of birth is so important for On-Time vaccine reminders because we will send a reminder 1 week prior to the due date based on your given date of birth so that you can plan accordingly. You can change it once if you make a mistake. You have to reach us if you want to change it <span>2nd</span> time.
                 
                <br><br>2.	Need your correct phone number &amp; email ID so that you receive notification 1 week prior to vaccine due date.
                
                <br><br>3.	Please fill the date of taking the vaccine into the system so that we can send you a reminder for the next dose based on the last dose because sometimes you may miss the exact date due to <span>non-availability</span> of the vaccine. If you make any mistake of giving the wrong date, <span>you can change it once.</span> After that it will freeze &amp; you need to contact us for amendment.
                
                <br><br>4.	If you did not fill the last dose date, we will still send you a reminder of the next dose considering you have given the last dose on time. 
                
                <br><br>5.	Vaccines provided by the Bangladesh government are free for all babies. You will be able to give these vaccines without charge from all government &amp; private hospitals/clinics. 
                
                <br><br>6.	Repeat vaccine means you need to give this vaccine your whole life with specific intervals. Like Influenza once in every year, Typhoid once in every 3 year, Yellow fever &amp; DTap once in every 10 years.
                
                <br><br>7.	A user can add multiple new users for his/her child/parents/wife/husband by clicking add user. You can use the same mobile or email id for all users. <span>Payment is required for each new user.</span>
                
                <br><br>8.	You can transfer your sub user at any time to another existing or new user.
                <br><br>9.	You can see a Horizontal &amp; Vertical view of all vaccines.
                
                <br><br>10.	You can see all vaccine details information together at dashboard. Or any particular vaccine details from all vaccine information by selecting one.
                
                <br><br>11.	Missed &amp; non updated vaccines will be highlighted as RED.  
                Due date within 7 days of your vaccine will be highlighted as YELLOW. 
                <span>Completed and updated vaccines</span> will be highlighted as GREEN.
                
                <br><br>12.	If you buy a green offer and do not want to update all previous vaccine information. Just update the last dose information in the system so that you will get the next due date reminder on time.
                </ul>
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

<input id="unread_message" value="{{App\Common::getUnreadMessageCount(Session::get('user_id'))}}">
<audio id="audio" src="{{asset('assets/message_sound.mp3')}}"></audio>

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
