@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="live-auction-block bg-white-smoke ptb-120">
        <div class="container ml-b-30">

            <div class="row items-two-1199 justify-content-center">

                @forelse($products as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="auction-item">
                            <div class="item-header">
                                <h3 class="heading"><a
                                        href="{{ route('auction.details', [$item->id, slug($item->name)]) }}">{{ __(@$item->name) }}</a>
                                </h3>
                                <div class="auction-id">@lang('Category'): {{ __(@$item->category->name) }}</div>
                            </div><!-- /.item-footer -->
                            <div class="item-img">
                                <a href="{{ route('auction.details', [$item->id, slug($item->name)]) }}">
                                    @forelse($item->images as $image)
                                        @if($loop->first)
                                            <img src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}"
                                                 alt="Thumbnail">
                                        @endif
                                        @if($loop->iteration == 2)
                                            <img class="prod2"
                                                 src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}"
                                                 alt="Thumbnail">
                                        @endif
                                    @empty
                                    @endforelse
                                </a>
                                <div class="bid-max">{{ count($item->bids) }} x <span class="icon-user-1"></span></div>
                                @if(count($item->bids) > 0)
                                    <div class="item-price">@lang('Highest Bid')
                                        : {{ $general->cur_sym }} {{ getAmount($item->bids->max('bid_amount')) }}</div>
                                @else
                                    <div class="item-price">@lang('No Bid Yet')</div>
                                @endif
                            </div><!-- /.item-img -->
                            <div class="item-footer">
                                <div class="item-footer-top">
                                    <div
                                        class="bid-price">{{ $general->cur_sym }}{{ getAmount($item->min_bid_price) }}</div>
                                    <div class="bid-timer-area">

                                        @if(now()->between(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->start_date)->toDateTimeString(),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->end_date)->toDateTimeString()))
                                            <div id="bid_counter{{ $loop->iteration }}"
                                                 class="bid-timer">{{ $item->end_date }}</div>
                                            <p>@lang('Waiting For Bid')</p>
                                        @elseif($item->start_date > now() && $item->end_date > now())
                                            <div class="text-primary h4 font-weight-bold">@lang('Upcoming')</div>
                                        @else
                                            <div class="text-danger h4 font-weight-bold">@lang('Closed')</div>
                                        @endif

                                    </div>
                                </div>
                                <div class="bid-button">

                                    @if(now()->between(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->start_date)->toDateTimeString(),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->end_date)->toDateTimeString()))
                                        @auth
                                            <a href="javascript:void(0)" class="btn btn-default bidBtn"
                                               data-toggle="tooltip"
                                               data-url="{{ route('user.bid', [$item->id, slug($item->name)]) }}"
                                               data-min_bid_amount="{{ (count($item->bids) > 0)  ? ('Your bid should be greater than highest bid '.getAmount($item->bids->max('bid_amount')) . $general->cur_text) : ('Bid First! Minimum bid price ' . getAmount($item->min_bid_price) . $general->cur_text) }}"
                                               data-shipping_cost="{{ getAmount($item->shipping_cost) }}"
                                               data-name="{{ $item->name }}">
                                                @lang('Bid Now')
                                            </a>
                                        @else
                                            <a href="{{ route('user.login') }}" class="btn btn-default">@lang('Bid Now')</a>
                                        @endauth
                                    @endif
                                </div>
                            </div><!-- /.item-footer -->
                        </div><!-- /.auction-item -->
                    </div><!-- /.col-lg-4 -->
                @empty
                    <h3>@lang('No Product Found')</h3>
                @endforelse

            </div><!-- /.row -->
        </div>
    </div><!-- /.live-auction-block -->

    <!-- The Modal -->
    <div class="modal fade" id="bidModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white-smoke">

                <!-- Modal Header -->
                <div class="modal-header custom_border">
                    <h4 class="modal-title text-muted">@lang('Bid Now')</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form action="" method="post">
                @csrf

                <!-- Modal body -->
                    <div class="modal-body custom_border">
                        <div class="form-group">
                            <label for="amount">@lang('Bid Amount')</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-controller"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                       placeholder="0.00" required="" value="" autocomplete="off">
                                <div class="input-group-prepend">
                                <span
                                    class="input-group-text bg-white-smoke custom_border_span text-light">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-success text-center min_bid_amount"></p>
                        <p class="text-success text-center">@lang('Shipping Cost') <span id="shipping_cost"></span> {{ $general->cur_text }}</p>
                        <p class="text-success text-center total_payable"></p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary rounded">@lang('Bid Now')</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        #amount:focus {
            background: transparent;
            box-shadow: none;
        }

        .custom_border {
            border-bottom: 1px solid #e9ecef4f;
        }

        .custom_border_span {
            border: 1px solid #373768;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            /* ---------------------------------------------
                ## Auction Count Down
            --------------------------------------------- */
            var i;
            for (i = 1; i <= {{ $products->count() }}; i++) {
                var selector = '#bid_counter' + i;

                if ($(selector).length) {
                    // If you need specific date then comment out 1 and comment in 2
                    // let endDate = "2021/05/20"; //comment out this 1
                    let endDate = $(selector).text(); //comment out this 1
                    // let endDate = (new Date().getFullYear()) + '/' + (new Date().getMonth() + 1) + '/' + (new Date().getDate() + 1); // comment in this 2
                    let counterElement = document.querySelector(selector);
                    let myCountDown = new ysCountDown(endDate, function (remaining, finished) {
                        let message = "";
                        if (finished) {
                            message = "Expired";
                        } else {
                            var re_hours = (remaining.totalDays * 24) + remaining.hours;
                            message += re_hours + " : ";
                            message += remaining.minutes + " : ";
                            message += remaining.seconds;
                        }
                        counterElement.textContent = message;
                    });
                }
            }

            // Bid
            $('.bidBtn').on('click', function () {
                $('#amount').val("");

                var modal = $('#bidModal');
                var url = $(this).data('url');
                var min_bid_amount = $(this).data('min_bid_amount');
                var shipping_cost = $(this).data('shipping_cost');

                $('.min_bid_amount').text(min_bid_amount);
                $('#shipping_cost').text(shipping_cost);

                modal.find('form').attr('action', url);
                modal.modal('show');

                $(document).on("keyup", "#amount", function () {
                    var amount = $(this).val();
                    var total_payable = (parseFloat(shipping_cost) + parseFloat(amount));
                    if (amount){
                        $('.total_payable').text('Total Payable Amount '+ total_payable + @json($general->cur_text));
                    }else {
                        $('.total_payable').text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
