@extends($activeTemplate.'layouts.master')
@section('content')
    <section class="ptb-120">
        <div class="container">
            <div class="row mb-none-30 justify-content-center">
                <div class="col-lg-12 mb-30">
                    <div class="form-group">
                        <label>@lang('Referral Link')</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-controller" id="referralURL" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.deposit') }}" title="@lang('Deposit Now')">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="las la-wallet p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $general->cur_sym }}{{ $widget['current_balance'] }}</h3>
                                        <p class="m-0">@lang('Current Balance')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.deposit.history') }}">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="las la-credit-card p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $general->cur_sym }}{{ $widget['total_deposit'] }}</h3>
                                        <p class="m-0">@lang('Total Deposit')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.bids.list') }}">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="lab la-blogger p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $widget['total_bid'] }}</h3>
                                        <p class="m-0">@lang('Total Bid')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.bids.list') }}">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="las la-hand-holding-usd p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $general->cur_sym }}{{ getAmount($widget['total_bid_amount']) }}</h3>
                                        <p class="m-0">@lang('Total Bid Amount')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.winning.products') }}">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="la la-trophy p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $widget['win_products'] }}</h3>
                                        <p class="m-0">@lang('Win Products')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-30">
                    <a class="d-block" href="{{ route('user.transactions.history') }}">
                        <div class="custom-box-shadow rounded mb-4">
                            <div class="d-flex">
                                <div class="bg-dashborad-card display-3 text-white d-flex align-items-center justify-content-center rounded">
                                    <i class="la la-exchange-alt p-2"></i>
                                </div>
                                <div class="dashboard--content d-flex align-items-center flex-column">
                                    <div class="py-4 px-3">
                                        <h3 class="post-title">{{ $widget['total_transactions'] }}</h3>
                                        <p class="m-0">@lang('Total Transactions')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <table class="table custom--table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('Transaction ID')</th>
                    <th scope="col">@lang('Amount')</th>
                    <th scope="col">@lang('Balance')</th>
                    <th scope="col">@lang('Details')</th>
                    <th scope="col">@lang('Date')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($latest_transactions as $k=>$data)
                    <tr>
                        <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                        <td data-label="@lang('Amount')" class="{{ $data->trx_type == '+' ? 'text-success' : 'text-danger' }}">{{ $data->trx_type . getAmount($data->amount)}} {{__($general->cur_text)}}</td>
                        <td data-label="@lang('Balance')" class="text-info">{{ getAmount($data->post_balance) }} {{__($general->cur_text)}}</td>
                        <td data-label="@lang('Details')">{{ $data->details }}</td>
                        <td data-label="@lang('Date')">
                            <i class="fa fa-calendar"></i> {{showDateTime($data->created_at)}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%"> @lang('No results found')!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
@push('style')
<style type="text/css">
  #copyBoard{
    cursor: pointer;
  }
  .form-control:disabled, .form-control[readonly] {
        background-color: #121f42f5;
        opacity: 1;
    }
    .input-group-text {
        background-color: #0a1227;
        border: 1px solid #373768;
        color: #fff;
    }
</style>
@endpush
@push('script')
    <script>
      $('.copyBoard').click(function(){
        "use strict";
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
      });
    </script>
@endpush