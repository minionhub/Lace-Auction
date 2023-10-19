@extends($activeTemplate.'layouts.master')


@section('content')
    <div class="container ptb-120">
        <div class="row  justify-content-center">
            <div class="col-md-8 custom-box-shadow bg-white-smoke p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ $data->gateway_currency()->methodImage() }}" class="mb-2">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <ul class="list-group text-center">
                            <p class="list-group-item bg-white-smoke">
                                @lang('Amount'):
                                <strong>{{getAmount($data->amount)}} </strong> {{__($general->cur_text)}}
                            </p>
                            <p class="list-group-item bg-white-smoke">
                                @lang('Charge'):
                                <strong>{{getAmount($data->charge)}}</strong> {{__($general->cur_text)}}
                            </p>
                            <p class="list-group-item bg-white-smoke">
                                @lang('Payable'): <strong> {{getAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}
                            </p>
                            <p class="list-group-item bg-white-smoke">
                                @lang('Conversion Rate'): <strong>1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</strong>
                            </p>
                            <p class="list-group-item bg-white-smoke">
                                @lang('In') {{$data->baseCurrency()}}:
                                <strong>{{getAmount($data->final_amo)}}</strong>
                            </p>


                            @if($data->gateway->crypto==1)
                                <p class="list-group-item bg-white-smoke">
                                    @lang('Conversion with')
                                    <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                </p>
                            @endif
                        </ul>

                        @if( 1000 >$data->method_code)
                            <a href="{{route('user.deposit.confirm')}}" class="btn btn-default btn-block py-3 mt-3 font-weight-bold">@lang('Pay Now')</a>
                        @else
                            <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn-default btn-block py-3 font-weight-bold">@lang('Pay Now')</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop


