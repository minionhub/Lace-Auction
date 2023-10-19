@extends($activeTemplate .'layouts.master')
@section('content')
<div class="container ptb-120">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card text-center bg-white-smoke custom-box-shadow pt-4">
                        <div class="card-header">@lang('2FA Verification')</div>
                        <div class="card-body">
                            <form action="{{route('user.go2fa.verify')}}" method="POST" class="login-form">
                                @csrf
                                <div class="form-group">
                                    <p class="text-center">@lang('Current Time'): {{\Carbon\Carbon::now()}}</p>
                                </div>
                                <div class="form-group">
                                    <h5 class="col-md-12 mb-3 text-center">@lang('Google Authenticator Code')</h5>
                                    <div id="phoneInput">
                                        <div class="field-wrapper">
                                            <div class=" phone">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="code[]" class="letter form-controller" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-area text-center">
                                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush
@push('style')
    <style>
        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
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
            border-radius: 0;
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
