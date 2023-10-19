@extends($activeTemplate.'layouts.frontend')

@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Product Details Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="product-details-block ptb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-main-thumb-area">
                        <div id="product-main-thumb" class="product-main-thumb">
                            @forelse($product->images as $image)
                                @if($loop->first)
                                    <img src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}"
                                         alt="big-1" class="w-100">
                                @endif
                            @empty
                            @endforelse
                        </div>
                        <div class="product-slider-area">
                            <div class="owl-carousel single-product-slider carousel-nav-align-center">
                                @forelse($product->images as $image)
                                    <div class="active-gallery">
                                        <img src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}" alt="thumbnail"/>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div><!-- /.product-main-thumb-area -->
                </div>
                <div class="col-lg-6">
                    <div class="auction-item-details md-mrt-55">
                        <h3 class="heading">{{ __(@$product->name) }}</h3>
                        <div class="item-bid-price-time">
                            <div class="bid-price">{{ $general->cur_sym }}{{ getAmount(@$product->min_bid_price) }}</div>

                            @if(now()->between(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$product->start_date)->toDateTimeString(),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$product->end_date)->toDateTimeString()))
                                @auth
                                    <div class="bid-timer-area">
                                        <div id="bid_counter1" class="bid-timer">{{ $product->end_date }}</div>
                                        <p>@lang('Waiting For Bid')</p>
                                    </div>
                                    <div class="bid-button">
                                        <button class="btn btn-default" type="button" data-toggle="modal" data-target="#bidModal">
                                            @if($product->userBidExist())
                                                @lang('Update Bid')
                                            @else
                                                @lang('Bid Now')
                                            @endif
                                        </button>
                                    </div>
                                @else
                                    <div class="bid-timer-area">
                                        <div id="bid_counter1" class="bid-timer">{{ $product->end_date }}</div>
                                        <p>@lang('Waiting For Bid')</p>
                                    </div>
                                    <div class="bid-button">
                                        <a class="btn btn-default" href="{{ route('user.login') }}">@lang('Bid Now')</a>
                                    </div>
                                @endauth
                            @elseif($product->start_date > now() && $product->end_date > now())
                                <div class="bid-timer-area">
                                    <div id="bid_counter1" class="bid-timer">{{ $product->start_date }}</div>
                                    <p>@lang('Waiting For Bid')</p>
                                </div>
                                <div class="bid-button">
                                    <div class="text-primary h4 font-weight-bold">@lang('Upcoming')</div>
                                </div>
                            @else
                                <div class="bid-timer-area">
                                    <div class="bid-timer">{{ $product->winner->user->fullname }}</div>
                                    @if($product->winner->bid->bid_amount)
                                        <p>@lang('Bid Amount') {{ $general->cur_sym }} {{ getAmount($product->winner->bid->bid_amount) }}</p>
                                    @endif
                                </div>
                                <div class="bid-button">
                                    <div class="text-danger h4 font-weight-bold">@lang('Closed')</div>
                                </div>
                            @endif

                        </div><!-- /.item-bid-price-time -->
                        <div class="item-info-area">
                            <div class="filter-info-tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li>
                                        <a class="active" data-toggle="tab" href="#auction_info" role="tab">@lang('Auction Information')</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#auction_history" role="tab">@lang('Bidding History')</a>
                                    </li>
                                </ul>
                            </div><!--~./ end filter info tab ~-->

                            <div class="tab-content filter-info-tab-content">
                                <!--~~~~~ Start Tab Pane ~~~~~-->
                                <div class="tab-pane fade active show" id="auction_info" role="tabpanel" data-animate="hg-fadeInUp">
                                    <ul class="item-info">
                                        <li>@lang('Category') : <span>{{ $product->category->name }}</span></li>
                                        <li>@lang('Shipping Cost') : <span>{{ $general->cur_sym }}{{ getAmount(@$product->shipping_cost) }}</span></li>
                                        <li>@lang('Start Date') : <span>{{ @showDateTime($product->start_date) }}</span></li>
                                        <li>@lang('End Date') : <span>{{ @showDateTime($product->end_date) }}</span></li>
                                        <li>@lang('Delivery Time') : <span>{{ $product->delivery_time }}</span></li>
                                    </ul>
                                </div><!--~./ end tab pane ~-->

                                <!--~~~~~ Start Tab Pane ~~~~~-->
                                <div class="tab-pane fade" id="auction_history" role="tabpanel">
                                    <div class="table-responsive auction-history-table"  data-animate="hg-fadeInUp">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="history-price">@lang('Price')</th>
                                                <th class="history-time">@lang('Bid Time')</th>
                                                <th class="history-user">@lang('User')</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @forelse($product->bids as $item)
                                                <tr>
                                                    <td class="history-price">{{ $general->cur_sym }}{{ getAmount($item->bid_amount) }}</td>
                                                    <td class="history-time">{{ showDateTime($item->created_at) }}</td>
                                                    <td class="history-user">{{ $item->user->fullname }}</td>
                                                </tr>
                                            @empty
                                            @endforelse

                                            </tbody>
                                        </table>
                                    </div><!-- /.auction-history-table -->
                                </div><!--~./ end tab pane ~-->
                            </div><!-- /.filter-pricing-tab-content -->
                        </div>
                    </div><!-- /.auction-item-details -->
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="product-description pd-t-120">
                        <div class="product-des-header">
                            <h2 class="section-heading">@lang('Product Overview')</h2>
                        </div>
                        <div class="product-des-info">
                            <p>@php echo @$product->description @endphp</p>
                            <div class="table-responsive product-info-table"  data-animate="hg-fadeInUp">
                                <table class="table">
                                    <tbody>

                                    @forelse($product->others_info as $key => $item)
                                        <tr>
                                            <td class="info-title">{{ __(@$key) }}</td>
                                            <td class="info-dsc">{{ __(@$item) }}</td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>
                            </div><!-- /.auction-history-table -->

                            <p class="mt-3"><i class="fa fa-tags"></i> @lang('Tags'):
                                @if($product->keywords)
                                @foreach($product->keywords as $item)
                                    <a href="{{ route('product.search', ['product' => $item]) }}"><span class="badge badge-dark">{{ $item }}</span></a>
                                @endforeach
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--~./ end product details ~-->

    <!-- The Modal -->
    <div class="modal fade" id="bidModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white-smoke">

                <!-- Modal Header -->
                <div class="modal-header custom_border">
                    <h4 class="modal-title text-muted">@lang('Bid Now')</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{ route('user.bid', [$product->id, slug($product->name)]) }}" method="post">
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


                        <p class="text-success text-center min_bid_amount">{{ (count($product->bids) > 0)  ? ('Your bid should be greater than highest bid '.getAmount($product->bids->max('bid_amount')) . $general->cur_text) : ('Bid First! Minimum bid price ' . getAmount($product->min_bid_price) . $general->cur_text) }}</p>

                        <p class="text-success text-center">@lang('Shipping Cost') {{ getAmount($product->shipping_cost) }}{{ $general->cur_text }}</p>
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


@push('script')
    <script>
        (function ($) {
            "use strict";

            /* ---------------------------------------------
                ## Auction Count Down
            --------------------------------------------- */
            var selector = '#bid_counter1';

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

            // Bid
            $(document).on("keyup", "#amount", function () {
                var amount = $(this).val();
                var shipping_cost = @json(getAmount($product->shipping_cost));
                var total_payable = (parseFloat(shipping_cost) + parseFloat(amount));
                if (amount){
                    $('.total_payable').text('Total Payable Amount '+ total_payable + @json($general->cur_text));
                }else {
                    $('.total_payable').text('');
                }
            });

        })(jQuery);
    </script>
@endpush

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
