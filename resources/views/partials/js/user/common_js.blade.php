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

    function re_init_phone_velidation(){
        var input = document.querySelector("#telephone");
        if(input !=null){
            var iti = window.intlTelInput(input, {
                initialCountry: "bd",
                separateDialCode: true,
                utilsScript: "assets/global/plugins/intl-tel-input-master/js/utils.js"
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

    function getFormattedDate(original_date,format=''){
        const dayNames = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday",
            "Sunday"
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
        else if(format=='y-m-d'){
            if(d<10){
                d = '0'+d;
            }
            m = m+1;
            if(m<10){
                m = '0'+m;
            }
            return y + "-" + m + "-" + d;
        }
        else if(format=='M d'){
            return monthNames[m-1] + " " + d;
        }
        else if(format=='M-d-y'){
            return monthNames[m-1] + "-" + d + "-" + y;
        }
        else if(format=='l M d, Y h:i a'){
            return (dayNames[day] + ' ' + monthNames[m-1] + ' ' + d +', ' + y + ' ' + hours + ':' + minutes +' '+ampm);
        }
        else{
            return monthNames[m-1] + " " + d + ", " + y;
        }
    }

    $(document).on('change','#day, #month, #year',function(){
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var date = year+'-'+month+'-'+day;

        $('#shipment_date').val(date);
    });

    function isFutureDate(date){
        var CurrentDate = new Date();
        var GivenDate = new Date(date);

        if(GivenDate > CurrentDate){
            return 1;
        }
        
        return 0;
    }

</script>
