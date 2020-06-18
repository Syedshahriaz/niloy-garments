
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
    <div class="page-footer-inner"> 2020 &copy;</div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!-- BEGIN FOOTER scripts-->
@include('partials.scripts')
<!-- END FOOTER scripts-->
<script>
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
            var browser_title = item_name.substr(0,1).toUpperCase()+item_name.substr(1);
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
                    show_error_message(data);
                }
            },
            error: function (data) {
                show_error_message(data);
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
        re_initiate_date_picker();
        if(item_name=='add_user'){
            $("#telephone").intlTelInput("setNumber", "");
            re_initialize_data_table(3);
        }
        if(item_name=='item_activity'){
            re_initialize_data_table(3);
        }
        if(item_name=='borrowing_activities'){
            re_initialize_data_table(12);
        }
    }

    /*
    * Reloading page on browser back and forth button click
    * */
    $(window).on('popstate', function(event) {
        window.location.reload();
    });
</script>
@yield('js')

@include('partials.js.user.common_js')
@include('partials.js.user.project_js')
@include('partials.js.user.user_js')

</body>

</html>
