<form id="login_form" method="POST" action="">
{{ csrf_field() }}
    <div class="alert alert-success" id="success_message" style="display:none"></div>
    <div class="alert alert-danger" id="error_message" style="display: none"></div>

</form>

<script type="text/javascript">
    /*Ajax full form submit*/
    $(document).on("submit", "#login_form", function(event) {
        event.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();

        var validate = "";

        if (email.trim() == "") {
            validate = validate + "Email is required</br>";
        }
        if (password == "") {
            validate = validate + "Password is required</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#login_form")[0]);
            var url = "{{ route('post_login') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        window.location.href = "{{ url('artist') }}";
                        //show_success_message(data.reason);
                        //$("#success_message").show();
                        //$("#error_message").hide();
                        //$("#error_message").html(data.reason);
                    } else {
                        //show_error_message(data.reason);
                        //$("#success_message").hide();
                        //$("#error_message").show();
                        //$("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    $("#success_message").hide();
                    $("#error_message").show();
                    $("#error_message").html(data.reason);
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
    });

    /*Ajax full form submit*/
    function single_ajax_submit() {

        var email = $("#email").val();
        var password = $("#password").val();

        var validate = "";

        if (email.trim() == "") {
            validate = validate + "Email is required</br>";
        }
        if (password == "") {
            validate = validate + "Password is required</br>";
        }

        if (validate == "") {
            var url = "{{ url('post_login') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {project_id:project_id,status:'deleted','_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        $('#warning_modal').modal('hide');
                        show_success_message('Successfully deleted');
                        setTimeout(function(){
                            location.reload();
                        },2000);
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
        } else {
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    }
</script>
