@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container ptb-120">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 text-center">
                <div class="card custom-box-shadow bg-white-smoke p-2">
                    <div class="card-body">
                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt="@lang('Image')">
                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <h3 class="text-center mt-2">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                            <h3 class="my-2 text-center">@lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</h3>
                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
                            </script>
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            $('input[type="submit"]').addClass("mt-4 btn btn-default btn-block btn-custom2 text-center");
        })
    </script>
@endpush
