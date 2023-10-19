@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $account_content = getContent('account_image.content', true);
    @endphp
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

                            <form class="default-form signin-form" action="{{ route('user.password.verify-code') }}" method="POST">
                                @csrf

                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="form-group">
                                    <label for="email">@lang('Verification Code')</label>

                                    <div id="phoneInput">
                                        <div class="field-wrapper">
                                            <div class=" phone">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter"
                                                       pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">@lang('Verify Code') <i
                                            class="las la-sign-in-alt"></i></button>
                                </div>

                                <div class="form-group d-flex justify-content-between align-items-center">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div><!-- /.col-lg-10 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush
@push('style')
    <style>

        #phoneInput .field-wrapper {
            position: relative;
        }

        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }

        #phoneInput .letter {
            height: 50px;
            text-align: center;
            max-width: calc((100% / 10) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
            border-radius: 5px;
            border: 1px solid #373768;
            background-color: transparent;
        }

        #phoneInput .letter + .letter {
        }

        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }

            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        $(function () {
            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
                onLetterKeyup: function ($item, event) {
                    console.log('$item:', $item);
                    console.log('event:', event);
                },
                onSet: function ($el, event, value) {
                    console.log('element:', $el);
                    console.log('event:', event);
                    console.log('value:', value);
                }
            });
        });
    </script>
@endpush
