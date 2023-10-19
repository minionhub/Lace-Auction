@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container ptb-120">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card custom-box-shadow bg-white-smoke">
                    <div class="card-body">
                        <form class="register" action="" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="profile-thumb-wrapper text-center">
                                <div class="profile-thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url('{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}')"></div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" id="profilePicUpload1" name="image" accept="image/*">
                                        <label for="profilePicUpload1"><i class="la la-pencil"></i></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="form-group col-sm-6">
                                    <label for="InputFirstname" class="col-form-label">@lang('First Name'):</label>
                                    <input type="text" class="form-controller" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                                    <input type="text" class="form-controller" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="email" class="col-form-label">@lang('E-mail Address'):</label>
                                    <input type="email" class="form-controller" id="email" name="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="hidden" id="track" name="country_code">
                                    <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                    <input type="tel" class="form-controller pranto-control" id="phone" name="mobile" value="{{$user->mobile}}" placeholder="@lang('Your Contact Number')" readonly>
                                </div>
                                <input type="hidden" name="country" id="country" class="form-controller d-none" value="{{@$user->address->country}}">
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="address" class="col-form-label">@lang('Address'):</label>
                                    <input type="text" class="form-controller" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state" class="col-form-label">@lang('State'):</label>
                                    <input type="text" class="form-controller" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="zip" class="col-form-label">@lang('Zip Code'):</label>
                                    <input type="text" class="form-controller" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="city" class="col-form-label">@lang('City'):</label>
                                    <input type="text" class="form-controller" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-block btn-default">@lang('Update Profile')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
    <link href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
@endpush

@push('script')
    <script>
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.profile-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });
    </script>
@endpush
