
@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $account_content = getContent('account_image.content', true);
    @endphp
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            User Sign up Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="user-signin-block ptb-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="sing-in-mockup md-mrb-60">
                        <img
                            src="{{ getImage('assets/images/frontend/account_image/' . @$account_content->data_values->image, '667x606') }}"
                            alt="Mockup">
                    </div>
                </div><!--/.col-lg-2-->
                <div class="col-lg-6">
                    <div class="user-register-area">
                        <div class="form-content">
                            <div class="form-header">
                                <h4 class="form-subheading">@lang('Sign up here')</h4>
                                <h2 class="heading">@lang('Welcome To') {{ $general->sitename }}</h2>
                            </div>

                            <form class="default-form signup-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                                @csrf

                                <div class="row">
                                    @if(session()->get('reference') != null)
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="referenceBy">@lang('Reference By')</label>
                                                <input type="text" name="referBy" id="referenceBy" class="form-controller" value="{{session()->get('reference')}}" readonly>
                                            </div><!--/.form-group-->
                                        </div>
                                    @endif

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstname">@lang('First Name')</label>
                                            <input id="firstname" type="text" class="form-controller" name="firstname" value="{{ old('firstname') }}" required>
                                        </div><!--/.form-group-->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastname">@lang('Last Name')</label>
                                            <input id="lastname" type="text" class="form-controller" name="lastname" value="{{ old('lastname') }}" required>
                                        </div><!--/.form-group-->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">@lang('Username')</label>
                                            <input id="username" type="text" class="form-controller" name="username" value="{{ old('username') }}" required>
                                        </div><!--/.form-group-->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">@lang('E-Mail Address')</label>
                                            <input id="email" type="email" class="form-controller" name="email" value="{{ old('email') }}" required>
                                        </div><!--/.form-group-->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="phone">@lang('Mobile')</label>
                                            <div class="form-group country-code">

                                                <div class="input-group ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <select name="country_code">
                                                                @include('partials.country_code')
                                                            </select>
                                                        </span>
                                                    </div>
                                                    <input type="text" id="phone" name="mobile" class="form-control" placeholder="@lang('Your Phone Number')">
                                                </div>
                                            </div>
                                        </div><!--/.form-group-->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="country">@lang('Country')</label>
                                            <input type="text" id="country" name="country" class="form-controller" readonly>
                                        </div><!--/.form-group-->
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group hover-input-popup">
                                            <label for="password">@lang('Password')</label>
                                            <input id="password" type="password" class="form-controller" name="password" required>
                                            @if($general->secure_password)
                                                <div class="input-popup">
                                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                                    <p class="error number">@lang('1 number minimum')</p>
                                                    <p class="error special">@lang('1 special character minimum')</p>
                                                    <p class="error minimum">@lang('6 character password')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password-confirm">@lang('Confirm Password')</label>
                                            <input id="password-confirm" type="password" class="form-controller" name="password_confirmation" required autocomplete="new-password">
                                        </div><!--/.form-group-->
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 ">
                                    </div>
                                    <div class="col-md-6 ">
                                        @php echo recaptcha() @endphp
                                    </div>
                                </div>
                                @include($activeTemplate.'partials.custom-captcha')

                                <div class="form-btn-group">
                                    <div class="form-login-area">
                                        <button type="submit" id="recaptcha" class="btn btn-default btn-primary">
                                            @lang('Register')
                                        </button>
                                    </div>
                                    <div class="login-form-register-now">
                                        @lang('Already Have an account?') <a class="btn-register-now" href="{{route('user.login')}}">@lang('Sign In')</a>
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
@push('style')
    <style type="text/css">
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
            background: transparent;
            color: white;
        }

        .country-code select option {
            color: black;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .country-code .input-group-prepend .input-group-text {
            background: transparent !important;
            border: 1px solid #373768;
        }

        #phone{
            border-radius: 5px;
            border: 1px solid #373768;
            background-color: transparent;
            height: 50px;
            outline: none;
            padding: 5px 15px;
            color: #a2aec2;
        }

        #phone:focus {
            border-color: #6449e7;
            box-shadow: none;
        }

        .hover-input-popup {
            position: relative;
        }
        .hover-input-popup:hover .input-popup {
            opacity: 1;
            visibility: visible;
        }
        .input-popup {
            position: absolute;
            bottom: 72%;
            left: 80%;
            width: 260px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        .input-popup::after {
            position: absolute;
            content: '';
            bottom: -19px;
            left: 50%;
            margin-left: -5px;
            border-width: 10px 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #1a1a1a transparent;
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .input-popup p {
            padding-left: 20px;
            position: relative;
        }
        .input-popup p::before {
            position: absolute;
            content: '';
            font-family: 'Line Awesome Free';
            font-weight: 900;
            left: 0;
            top: 4px;
            line-height: 1;
            font-size: 18px;
        }
        .input-popup p.error {
            text-decoration: line-through;
        }
        .input-popup p.error::before {
            content: "\f057";
            color: #ea5455;
        }
        .input-popup p.success::before {
            content: "\f058";
            color: #28c76f;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        @if($country_code)
        $(`option[data-code={{ $country_code }}]`).attr('selected', '');
        @endif
        $('select[name=country_code]').change(function () {
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();

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

        @if($general->secure_password)
        $('input[name=password]').on('input',function(){
            secure_password($(this));
        });
        @endif
    </script>
@endpush
