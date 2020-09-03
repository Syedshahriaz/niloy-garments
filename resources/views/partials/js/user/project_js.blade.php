<script>
    /*
    * ******** Select shipment js
    * */
    $(document).on("submit", "#shipment_form", function(event) {
        event.preventDefault();

        $('#done_button').prop('disabled',true);

        show_loader();

        var shipment_date = $("#shipment_date").val();
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();

        var validate = "";

        if (shipment_date.trim() == "") {
            validate = validate + "Shipment date is required</br>";
        }

        if (day.trim() == "" || month.trim() =='' || year.trim() =='') {
            validate = validate + "Shipment date is required</br>";
        }


        if (validate == "") {
            var formData = new FormData($("#shipment_form")[0]);
            var url = "{{ url('store_shipment') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('all_project')}}";
                        },2000)
                    } else {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    $('#done_button').prop('disabled',false);
                    hide_loader();
                    $("#success_message").hide();
                    $("#error_message").show();
                    $("#error_message").html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            $('#done_button').prop('disabled',false);
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });

    /*
    **********  All project js
    * */

    $(document).on('click','#change_special_date', function(event){
        event.stopPropagation();
        var user_project_id = $(this).attr('data-id');
        show_special_date_modal(user_project_id);
    })

    function show_special_date_modal(user_project_id){
        $('#user_project_id').val(user_project_id);
        $('#special_date_modal').modal('show');
    }

    $(document).on("submit", "#special_date_form", function(event) {
        event.preventDefault();

        show_loader();

        var special_date = $("#sp_date").val();
        var user_project_id = $("#user_project_id").val();

        var validate = "";

        if (special_date.trim() == "") {
            validate = validate + "Special date is required</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#special_date_form")[0]);
            var url = "{{ url('update_project_special_date') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        $('#special_date_modal').modal('hide');

                        setTimeout(function(){
                            var item_name = 'my_project_task/'+user_project_id;
                            var browser_title = 'My Project Task';
                            var uri_string = '/'+item_name;
                            var url = "{{url('/')}}"+uri_string;
                            load_new_page_content(url,item_name,browser_title);
                        },200)

                    } else {
                        show_error_message(data.reason);
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });



    /*
    * ********** my project task js
    * */
    //User task page
    $(document).on('click','#vertical_view_btn', function(){
        $(this).removeClass('btn-outline');
        $('#horzon_view_btn').addClass('btn-outline');
        $('#user_horizontal_task,.DTFC_ScrollWrapper').addClass('hidden');
        $('#user_vertical_task').removeClass('hidden');
    });
    $(document).on('click','#horzon_view_btn', function(){
        $(this).removeClass('btn-outline');
        $('#vertical_view_btn').addClass('btn-outline');
        $('#user_vertical_task').addClass('hidden');
        $('#user_horizontal_task,.DTFC_ScrollWrapper').removeClass('hidden');
    });

    //User dashboard task page
    $(document).on('click','#vertical_dash_view_btn', function(){
        $(this).removeClass('btn-outline');
        $('#horzon_dash_view_btn').addClass('btn-outline');
        $('#user_dash_horizontal_task').addClass('hidden');
        $('#user_dash_vertical_task').removeClass('hidden');
    });
    $(document).on('click','#horzon_dash_view_btn', function(){
        $(this).removeClass('btn-outline');
        $('#vertical_dash_view_btn').addClass('btn-outline');
        $('#user_dash_vertical_task').addClass('hidden');
        $('#user_dash_horizontal_task').removeClass('hidden');
    });

    function select_delivery(id,original_delivery_date,update_count){
        $('#project_task_id').val(id);

        var formattedDate = new Date();

        var d = formattedDate.getDate();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();

        $('#day').val(d);
        $('#month').val(m);
        $('#year').val(y);

        $('#shipment_date').val(original_delivery_date);
        $('#old_delivery_date_hidden').val(original_delivery_date);
        if(update_count>1){
            $('#org_delivery_date').prop('disabled',true);
        }
        else{
            $('#org_delivery_date').prop('disabled',false);
        }
        $('#select_delivery_modal').modal('show');
    }

    $(document).on("submit", "#delivery_form", function(event) {
        event.preventDefault();

        show_loader();

        var org_delivery_date = $("#org_delivery_date").val();
        var user_project_id = $("#user_project_id").val();

        var validate = "";

        /*if (org_delivery_date.trim() == "") {
            validate = validate + "Delivery date is required</br>";
        }*/

        if (validate == "") {
            var formData = new FormData($("#delivery_form")[0]);
            var url = "{{ url('update_task_delivery_status') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {

                        $('#org_delivery_date').val('');
                        $('#select_delivery_modal').modal('hide');

                        setTimeout(function(){
                            var item_name = 'my_project_task/'+user_project_id;
                            var browser_title = 'My Project Task';
                            var uri_string = '/'+item_name;
                            var url = "{{url('/')}}"+uri_string;
                            load_new_page_content(url,item_name,browser_title);
                        },200)

                    } else {
                        show_error_message(data.reason);
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });

</script>
