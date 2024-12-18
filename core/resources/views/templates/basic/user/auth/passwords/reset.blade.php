@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $account_content = getContent('account_image.content', true);
    @endphp
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            User Signin Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="user-signin-block pd-t-80 pd-b-80">
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
                                <h2 class="heading">@lang('Reset Password')</h2>
                            </div>

                            <form class="default-form signin-form" method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">

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

                                <div class="form-group">
                                    <label for="password-confirm">@lang('Confirm Password')</label>
                                    <input id="password-confirm" type="password" class="form-controller"
                                               name="password_confirmation" required autocomplete="new-password">
                                </div>


                                <div class="form-btn-group">
                                    <div class="form-login-area">
                                        <button type="submit" class="btn btn-default">
                                            @lang('Reset Password')
                                        </button>
                                    </div>
                                    <div class="login-form-register-now">
                                        <a class="btn-register-now" href="{{route('user.login')}}">@lang('Login')</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!-- /.col-lg-10 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
@endsection

@push('style')
    <style type="text/css">
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
            left: 70%;
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

        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    </script>
@endpush
