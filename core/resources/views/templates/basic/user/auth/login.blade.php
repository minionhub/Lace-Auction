@extends($activeTemplate.'layouts.frontend')

@section('content')

    @php
        $account_content = getContent('account_image.content', true);
    @endphp
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            User Signin Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="user-signin-block ptb-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="sing-in-mockup md-mrb-60">
                        <img src="{{ getImage('assets/images/frontend/account_image/' . @$account_content->data_values->image, '667x606') }}" alt="Mockup">
                    </div>
                </div><!--/.col-lg-2-->
                <div class="col-lg-6">
                    <div class="user-register-area">
                        <div class="form-content">
                            <div class="form-header">
                                <h4 class="form-subheading">@lang('Sign in here')</h4>
                                <h2 class="heading">@lang('Welcome To') {{ $general->sitename }}</h2>
                            </div>


                            <form class="default-form signin-form" method="POST" action="{{ route('user.login')}}"
                                  onsubmit="return submitUserForm();">
                                @csrf

                                <div class="form-group">
                                    <label for="username">@lang('Username or Email')</label>
                                    <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="@lang('Enter Your Username or Email')" class="form-controller" required>
                                </div><!--/.form-group-->

                                <div class="form-group">
                                    <label for="password">@lang('Password')</label>
                                    <input id="password" type="password" class="form-controller" name="password" autocomplete="current-password" placeholder="@lang('Enter Your Password')" required>
                                </div><!--/.form-group-->

                                <div class="form-group row">
                                    <div class="col-md-3 ">
                                    </div>
                                    <div class="col-md-6 ">
                                        @php echo recaptcha() @endphp
                                    </div>
                                </div>
                                @include($activeTemplate.'partials.custom-captcha')

                                <div class="remember-and-password">
                                    <div class="login-form-remember">
                                        <label for="remembermesignin"><input id="remembermesignin" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}><span>@lang('Remember Me')</span></label>
                                    </div>
                                    <div class="forget-pass">
                                        <a class="btn-password" href="{{route('user.password.request')}}">@lang('Forget Password?')</a>
                                    </div>
                                </div><!--/.remember-and-password-->

                                <div class="form-btn-group">
                                    <div class="form-login-area">
                                        <button type="submit" id="recaptcha" class="btn btn-default">
                                            @lang('Login')
                                        </button>
                                    </div>
                                    <div class="login-form-register-now">
                                        @lang('You have no account?') <a class="btn-register-now" href="{{route('user.register')}}">@lang('Register')</a>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div><!--~./ end user register area ~-->
                </div><!-- /.col-lg-10 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!--~~./ end user signin block ~~-->
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
