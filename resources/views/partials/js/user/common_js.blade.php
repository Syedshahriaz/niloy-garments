<script>
    function re_initialize_data_table(column_number){
        $('#user_horizontal_task').DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            scrollX:        true,
            fixedColumns:   true
        });
        $('#user_vertical_task').DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            // scrollCollapse: true,
            // scrollY:        200,
            // scroller:       true
        });
        $('#user_manage_table').DataTable({
            "paging":   true,
            "lengthChange": false,
            "info":     false,
            "searching": true,
        });
    }

    function re_initiate_date_picker(){
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            orientation: "left",
            autoclose: true,
            format: 'DD, MM dd, yyyy',
        });
        $('.date-picker').on('changeDate', function(e){
            $(this).next('input[type=hidden].date-picker-hidden').val( moment(e.date).format('DD-MM-YYYY') );
        });
    }

    function re_initiate_teliphone_plugin(){
        //iti.destroy();

        $(".telephone").intlTelInput({
            initialCountry:"BD",
            separateDialCode: true
            //dialCode: "+88",
        });
    }

    //image upload
    /*$(document).on('click','#upload_btn', function(e){
        e.preventDefault();
        $('#image_upload_input').click();
    });

    $(document).on('change','#image_upload_input', function(e){
        alert(11);
        readURL(this);
    });

    function readURL(input) {
        alert(22);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#uploaded_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            alert(33);
            $('#message_input').addClass('img-added')
            $('#uploaded_img').addClass('visible')
        }
    }*/

    function showUserGuide(){
        var user_guide_seen = "{{Session::get('user_guide_seen')}}";
        if(user_guide_seen == 0){
            setTimeout(function(){
                $('#GuideModal').modal('show');
            },2000);

            var url = "{{ url('update_user_guide_seen_status') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {'_token':'{{ csrf_token() }}'},
                success: function (data) {

                    if(data.status == 200){
                        //
                    }
                    else{
                        //
                    }
                },
                error: function (data) {
                    //show_error_message(data);
                }
            });
        }
    }
</script>
