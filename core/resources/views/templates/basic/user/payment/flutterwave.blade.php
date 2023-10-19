@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container ptb-120">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 text-center">
                <div class="card custom-box-shadow bg-white-smoke p-2">
                    <div class="card-body">
                        <h4 class="title"><span>@lang('Payment Preview')</span></h4>
                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top"
                             alt="@lang('Image')">
                        <h3 class="mt-2">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                        <h3 class="my-3">@lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</h3>
                        <button type="button" class="btn btn-default btn-block mt-2 btn-custom2 " id="btn-confirm"
                                onClick="payWithRave()">@lang('Pay Now')</button>
                        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                        <script>
                            var btn = document.querySelector("#btn-confirm");
                            btn.setAttribute("type", "button");
                            const API_publicKey = "{{$data->API_publicKey}}";

                            function payWithRave() {
                                var x = getpaidSetup({
                                    PBFPubKey: API_publicKey,
                                    customer_email: "{{$data->customer_email}}",
                                    amount: "{{$data->amount }}",
                                    customer_phone: "{{$data->customer_phone}}",
                                    currency: "{{$data->currency}}",
                                    txref: "{{$data->txref}}",
                                    onclose: function () {
                                    },
                                    callback: function (response) {
                                        var txref = response.tx.txRef;
                                        var status = response.tx.status;
                                        var chargeResponse = response.tx.chargeResponseCode;
                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        } else {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        }
                                        // x.close(); // use this to close the modal immediately after payment.
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
