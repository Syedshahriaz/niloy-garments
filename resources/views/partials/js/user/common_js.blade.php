<script>
    function re_initialize_data_table(column_number){
        $('#user_horizontal_task, #user_vertical_task').DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            //"responsive": true
        });
        $('#user_manage_table').DataTable({
            //"paging":   false,
            //"ordering": false,
            //"info":     false,
            //"searching": false,
            //"responsive": true
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
</script>
