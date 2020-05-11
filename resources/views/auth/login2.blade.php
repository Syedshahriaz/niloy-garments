@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id="login_form" method="POST" action="{{ url('login') }}">
                        {{csrf_field()}}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('email') is-invalid @enderror" name="username" value="{{ old('login_form') }}" autocomplete="email" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
    $(document).on("submit", "#login_form", function(event) {
        event.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();

        var validate = "";

        if (username.trim() == "") {
            validate = validate + "Username is required</br>";
        }
        if (password == "") {
            validate = validate + "Password is required</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#login_form")[0]);
            var url = "{{ url('post_login') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        window.location.href = "{{ url('home') }}";
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
            alert(validate);
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });
</script>

@endsection

@section('js')

@endsection
