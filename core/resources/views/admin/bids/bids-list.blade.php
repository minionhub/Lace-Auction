@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Product')</th>
                                <th scope="col">@lang('Bid Amount')</th>
                                <th scope="col">@lang('Shipping Cost')</th>
                                <th scope="col">@lang('Total Amount')</th>
                                <th scope="col">@lang('Bid Status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bids as $item)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($item->created_at) }}</td>
                                    <td data-label="@lang('User')">
                                        <div class="user justify-content-lg-center justify-content-end">
                                            <div class="thumb">
                                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$item->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')">
                                            </div>
                                            <a href="{{ route('admin.users.detail', $item->user_id) }}" class="ml-1">{{$item->user->fullname}}</a>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Product')">{{ $item->product->name }}</td>
                                    <td data-label="@lang('Bid Amount')">{{ $general->cur_sym . getAmount($item->bid_amount) }}</td>
                                    <td data-label="@lang('Shopping Cost')">{{ $general->cur_sym . getAmount($item->shipping_cost) }}</td>
                                    <td data-label="@lang('Total Amount')">{{ $general->cur_sym . getAmount($item->total_amount) }}</td>
                                    <td data-label="@lang('Bid Status')">
                                        @if(now()->between(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->product->start_date)->toDateTimeString(),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->product->end_date)->toDateTimeString()))
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Running')</span>
                                        @elseif($item->product->start_date > now() && $item->product->end_date > now())
                                            <span class="text--small badge font-weight-normal badge--primary">@lang('Upcoming')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Expired')</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($bids) }}
                </div>
            </div><!-- card end -->
        </div>

    </div>
@endsection
