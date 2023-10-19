@extends('templates.basic.layouts.frontend')

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
                        <img
                            src="{{ getImage('assets/images/frontend/account_image/' . @$account_content->data_values->image, '667x606') }}"
                            alt="Mockup">
                    </div>
                </div><!--/.col-lg-2-->
                <div class="col-lg-6">
                    <div class="user-register-area">
                        <div class="form-content">
                            <div class="form-header">
                                <h2 class="heading">@lang($page_title)</h2>
                            </div>

                            <form class="default-form signin-form" method="POST" action="{{ route('user.password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="my">@lang('Select Email or Username')</label>
                                    <select class="form-controller" id="my" name="type">
                                        <option value="email">@lang('E-Mail Address')</option>
                                        <option value="username">@lang('Username')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="value" class="my_value"></label>
                                    <input type="text" id="value" class="form-controller @error('value') is-invalid @enderror"
                                               name="value" value="{{ old('value') }}" required autofocus="off">

                                    @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-btn-group">
                                    <div class="form-login-area">
                                        <button type="submit" class="btn btn-default">
                                            @lang('Send Reset Code')
                                        </button>
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
    <script type="text/javascript">
        $('select[name=type]').change(function () {
            $('.my_value').text($('select[name=type] :selected').text());
        }).change();
    </script>
@endpush
