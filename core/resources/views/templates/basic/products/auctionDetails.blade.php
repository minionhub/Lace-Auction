@extends($activeTemplate . 'layouts.frontend')

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
                                @if ($loop->first)
                                    <img src="{{ getImage(imagePath()['products']['path'] . '/' . $image) }}" alt="big-1"
                                        class="w-100">
                                @endif
                            @empty
                            @endforelse
                        </div>
                        <div class="product-slider-area">
                            <div class="owl-carousel single-product-slider carousel-nav-align-center">
                                @forelse($product->images as $image)
                                    <div class="active-gallery">
                                        <img src="{{ getImage(imagePath()['products']['path'] . '/' . $image) }}"
                                            alt="thumbnail" />
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div><!-- /.product-main-thumb-area -->
                </div>
                <div class="col-lg-6">
                    <div class="auction-item-details md-mrt-55">
                        <div style="display: flex;">
                            <h3 class="heading">{{ __(@$product->name) }}</h3>
                            {{-- @if ($isProxy)
                                <img src="{{ asset('assets/images/proxy.gif') }}" alt="proxy bidding" style="{{ $isProxy?"display: none;" }} width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;">
                            @endif --}}
                            <p id="user_id" style="display: none;">{{ auth()->id() }}</p>
                            <img id="is_proxy" src="{{ asset('assets/images/proxy.gif') }}" alt="proxy bidding"
                                style="{{ $isProxy ? '' : 'display: none;' }} width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;">
                        </div>
                        <div class="item-bid-price-time">
                            <div class="bid-price">
                                {{ $general->cur_sym }}{{ getAmount(optional($product->bids->last())->bid_amount ?? $product->min_bid_price) }}
                            </div>
                            @if (now()->between(
                                    \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->start_date)->toDateTimeString(),
                                    \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->end_date)->toDateTimeString()))
                                @auth
                                    <div class="bid-timer-area">
                                        <div id="bid_counter1" class="bid-timer">{{ $product->end_date }}</div>
                                        <p>@lang('Waiting For Bid')</p>
                                    </div>
                                    <div class="bid-button">
                                        <button class="btn btn-default" type="button" data-toggle="modal"
                                            data-target="#bidModal">
                                            @if ($product->userBidExist())
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
                                    <div class="bid-timer">{{ $product->winner->bid->fullname }}</div>
                                    {{-- @if ($product->winner->bid->bid_amount)
                                        <p>@lang('Bid Amount') {{ $general->cur_sym }}
                                            {{ getAmount($product->winner->bid->bid_amount) }}</p>
                                    @endif --}}
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
                                        <a class="active" data-toggle="tab" href="#auction_info"
                                            role="tab">@lang('Auction Information')</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" id="bid_history" href="#auction_history"
                                            role="tab">@lang('Bidding History')</a>
                                    </li>
                                </ul>
                            </div><!--~./ end filter info tab ~-->

                            <div class="tab-content filter-info-tab-content">
                                <!--~~~~~ Start Tab Pane ~~~~~-->
                                <div class="tab-pane fade active show" id="auction_info" role="tabpanel"
                                    data-animate="hg-fadeInUp">
                                    <ul class="item-info">
                                        <li>@lang('Category') : <span>{{ $product->category->name }}</span></li>
                                        <li>@lang('Min Price') :
                                            <span>{{ $general->cur_sym }}{{ getAmount(@$product->min_bid_price) }}</span>
                                        </li>
                                        <li>@lang('Stock') :
                                            <span>{{ getAmount(@$product->stock) }}</span>
                                        </li>
                                        <li>@lang('Shipping Cost') :
                                            <span>{{ $general->cur_sym }}{{ getAmount(@$product->shipping_cost) }}</span>
                                        </li>
                                        <li>@lang('Start Date') : <span
                                                class="bid_time">{{ @showDateTime($product->start_date) }}</span>
                                        </li>
                                        <li>@lang('End Date') : <span
                                                class="bid_time">{{ @showDateTime($product->end_date) }}</span></li>
                                        <li>@lang('Delivery Time') : <span>{{ $product->delivery_time }}</span></li>
                                    </ul>
                                </div><!--~./ end tab pane ~-->

                                <!--~~~~~ Start Tab Pane ~~~~~-->
                                <div class="tab-pane fade" id="auction_history" role="tabpanel">
                                    <div class="table-responsive auction-history-table" data-animate="hg-fadeInUp">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="history-price">@lang('Price')</th>
                                                    <th class="history-time">@lang('Bid Time')</th>
                                                    <th class="history-user">@lang('User')</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @forelse($product->bids->reverse() as $item)
                                                    <tr>
                                                        <td class="history-price bid_amount">
                                                            {{ $general->cur_sym }}{{ getAmount($item->bid_amount) }}</td>
                                                        <td class="history-time bid_time">
                                                            {{ showDateTime($item->created_at) }}</td>
                                                        <td class="history-user bid_user">{{ $item->user->fullname }}</td>
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
                    <div class="product-description pd-t-80 pd-t-80">
                        <div class="product-des-header">
                            <h2 class="section-heading">@lang('Product Overview')</h2>
                        </div>
                        <div class="product-des-info">
                            <div style="display: flex;">
                                <p style="width: 80%;">@php echo @$product->description @endphp</p>

                                <div class="col-md-2 imageItem"
                                    style="width: 20%; max-width: 20%; flex: 1; align-self: flex-start;">
                                    <div class="payment-method-item">
                                        <div class="payment-method-header d-flex flex-wrap">
                                            <div class="thumb" style="position: relative; width: 100%; margin-bottom: 0;">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview">
                                                        @if ($product->pdf)
                                                            <a id="downloadLink"
                                                                href="{{ asset('assets/pdf/' . $product->pdf) }}"
                                                                download="{{ $product->pdf }}">
                                                                <iframe id="pdfPreview"
                                                                    src="{{ asset('assets/pdf/' . $product->pdf) }}"
                                                                    style="width: 100%; height: 100%; border: none;"></iframe>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($product->pdf)
                                                    <div class="avatar-edit">
                                                        <input type="button" name="pdf" class="profilePicUpload"
                                                            id="pdf_selection" onchange="" onclick="downloadPdf()" />
                                                        <label for="pdf_selection" class="bg-primary"><i
                                                                class="la la-download" style="color:#fff;"></i></label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive product-info-table" data-animate="hg-fadeInUp">
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
                                @if ($product->keywords)
                                    @foreach ($product->keywords as $item)
                                        <a href="{{ route('product.search', ['product' => $item]) }}"><span
                                                class="badge badge-dark">{{ $item }}</span></a>
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

                <form id="bidForm" action="{{ route('user.bid', [$product->id, slug($product->name)]) }}"
                    method="post">
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


                        <p class="text-success text-center min_bid_amount">
                            {{ count($product->bids) > 0 ? 'Your bid should be greater than highest bid ' . getAmount($product->bids->max('bid_amount')) . $general->cur_text : 'Bid First! Minimum bid price ' . getAmount($product->min_bid_price) . $general->cur_text }}
                        </p>

                        <p class="text-success text-center">@lang('Shipping Cost')
                            {{ getAmount($product->shipping_cost) }}{{ $general->cur_text }}</p>
                        <p class="text-success text-center total_payable"></p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer border-0">
                        <div style="display: flex; margin-right: auto; margin-left: 12px;">
                            <input type="checkbox" style="width: 16px; height: 16px; margin: auto;" name="proxyBidding"
                                id="proxyBid">
                            <label for="proxyBid" style="margin: 0; font-size: 16px; padding-left: 6px;"> Proxy
                                Bidding</label>
                        </div>
                        <button id="bidButton" type="button" class="btn btn-primary rounded">@lang('Bid Now')</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .avatar-edit {
            position: absolute;
            bottom: -15px;
            right: 0;
        }

        .avatar-edit label {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            border: 2px solid #fff;
            font-size: 18px;
            cursor: pointer;
        }

        .profilePicUpload {
            font-size: 0;
            opacity: 0;
            width: 0;
        }

        .form-edit-custom>div {
            width: 100% !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        function downloadPdf() {
            // Simulate a click on the anchor tag
            document.getElementById('downloadLink').click();
        }

        $(document).ready(function() {
            $('#bidButton').click(function(e) {
                e.preventDefault();

                // Get the form data
                var formData = $('#bidForm').serialize();

                // Get the CSRF token value
                var csrfToken = $('meta[name="csrf-token"]').attr('content');


                document.querySelector('#bidModal').classList.remove('show');
                document.querySelector('#bidModal').style = '';
                document.querySelector('body').classList.remove('modal-open');
                document.querySelector('body').style = '';
                document.querySelector('.modal-backdrop').remove();

                // get limit amount from notice string
                const inputString = $('.min_bid_amount').text();
                const numberPattern = /\d+/; // Matches one or more digits
                const match = inputString.match(numberPattern);
                var limit_amount;

                if (match) {
                    limit_amount = match[0];
                }

                if ($('#amount')[0].value > limit_amount) {
                    // Send an AJAX request
                    $.ajax({
                        url: $('#bidForm').attr('action'),
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            // Handle the response here
                            iziToast.success({
                                message: response[0][1],
                                timeout: 3000, // Timeout in milliseconds
                                position: 'topRight', // Display position (e.g., 'bottomRight', 'topLeft', 'topCenter')
                            });

                        },
                        error: function(xhr, status, error) {
                            // Handle the error here
                            iziToast.error({
                                message: response[0][1],
                                timeout: 3000, // Timeout in milliseconds
                                position: 'topRight', // Display position (e.g., 'bottomRight', 'topLeft', 'topCenter')
                            });
                        }
                    });
                } else {
                    iziToast.error({
                        message: $('.min_bid_amount').text(),
                        timeout: 3000, // Timeout in milliseconds
                        position: 'topRight', // Display position (e.g., 'bottomRight', 'topLeft', 'topCenter')
                    });
                }

            });
        });

        (function($) {
            "use strict";

            /* ---------------------------------------------
                ## Auction Count Down
            --------------------------------------------- */
            var selector = '#bid_counter1';

            if ($(selector).length) {
                // If you need specific date then comment out 1 and comment in 2
                // let endDate = "2021/05/20"; //comment out this 1
                // let endDate = $(selector).text(); //comment out this 1
                var serverTimeStr = document.querySelector('#serverTime').innerHTML;
                var serverTime = new Date(serverTimeStr);

                var clientTime = new Date();
                var timeGap = clientTime - serverTime;

                const dateString = new Date($(selector).text());
                const endDate = new Date(dateString.getTime() + timeGap);

                // let endDate = (new Date().getFullYear()) + '/' + (new Date().getMonth() + 1) + '/' + (new Date().getDate() + 1); // comment in this 2
                let counterElement = document.querySelector(selector);
                let myCountDown = new ysCountDown(endDate, function(remaining, finished) {
                    let message = "";
                    if (finished) {
                        message = "Expired";
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
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
            $(document).on("keyup", "#amount", function() {
                var amount = $(this).val();
                var shipping_cost = @json(getAmount($product->shipping_cost));
                var total_payable = (parseFloat(shipping_cost) + parseFloat(amount));
                if (amount) {
                    $('.total_payable').text('Total Payable Amount ' + total_payable +
                        @json($general->cur_text));
                } else {
                    $('.total_payable').text('');
                }
            });


        })(jQuery);

        //        Pusher.logToConsole = true;

        var pusher = new Pusher('8d579e60891f8897b5ac', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function(data) {
            if (data.message.bidder) {
                var dateString = data.message.bidtime;
                var isProxy = data.message.isProxy;

                var date = new Date();


                var options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true
                };

                var formattedDate = date.toLocaleDateString('en-US', options);

                var appendElement = "<tr><td class='history-price bid_amount'> $" + data.message.amount +
                    "</td><td class='history-time bid_time'>" + formattedDate +
                    "</td><td class='history-user bid_user'>" + data.message.bidder + "</td></tr>";
                appendElement += document.getElementsByTagName('tbody')[0].innerHTML;
                document.getElementsByTagName('tbody')[0].innerHTML = appendElement;

                document.querySelector('.min_bid_amount').innerHTML =
                    'Your bid should be greater than highest bid ' +
                    data.message.amount + 'USD';
                document.querySelector('.total_payable').innerHTML = '';

                if (document.querySelector('#user_id').innerHTML == isProxy)
                    document.querySelector('#is_proxy').style =
                    "display: block; width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;";
                else
                    document.querySelector('#is_proxy').style =
                    "display: none; width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;";
            } else {
                var isProxy = data.message.isProxy;
                if (document.querySelector('#user_id').innerHTML == isProxy)
                    document.querySelector('#is_proxy').style =
                    "display: block; width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;";
                else
                    document.querySelector('#is_proxy').style =
                    "display: none; width: 35px !important; height: 35px; margin-left: auto; margin-right: 10px;";
            }
        });
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
