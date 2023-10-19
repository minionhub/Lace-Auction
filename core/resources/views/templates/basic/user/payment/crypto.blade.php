@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container ptb-120">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 text-center">
                <div class="card card-deposit text-center custom-box-shadow bg-white-smoke p-2">
                    <h3>@lang('Payment Preview')</h3>
                    <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                    <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                    <img src="{{$data->img}}" alt="@lang('Image')">
                    <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
