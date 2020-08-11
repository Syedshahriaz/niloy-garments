
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
                    var message_count = data.messages.length;
                    if(message_count>0){
                        $('.new_message_count').removeClass('hidden');
                        $('.new_message_count').text(data.messages.length);
                    }
                    else{
                        $('.new_message_count').addClass('hidden');
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

</script>
@yield('js')
</body>

</html>
