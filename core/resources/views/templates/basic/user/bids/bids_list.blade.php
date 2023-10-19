@extends($activeTemplate.'layouts.master')
@section('content')
    <div class=" ptb-120">
        <div class="container ml-b-30">

            <div class="table-responsive custom-box-shadow">
                <table class="table custom--table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col">@lang('Product')</th>
                        <th scope="col">@lang('Bid Amount')</th>
                        <th scope="col">@lang('Shipping Cost')</th>
                        <th scope="col">@lang('Total Amount')</th>
                        <th scope="col">@lang('Bid Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($bids as $data)
                            <tr>
                                <td data-label="#@lang('Date')">{{ showDateTime($data->created_at) }}</td>
                                <td data-label="@lang('Product')"><a href="{{ route('auction.details', [$data->product_id, slug($data->product->name)]) }}" target="_blank">{{ __(@$data->product->name)  }}</a></td>
                                <td data-label="@lang('Bid Amount')">
                                    <strong>{{getAmount($data->bid_amount)}} {{__($general->cur_text)}}</strong>
                                </td>
                                <td data-label="@lang('Shipping Cost')">{{ getAmount($data->shipping_cost)  }} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Total Amount')">{{ getAmount($data->total_amount)  }} {{__($general->cur_text)}}</td>
                                <td>
                                    @if(now()->between(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->product->start_date)->toDateTimeString(),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->product->end_date)->toDateTimeString()))
                                        <span class="badge badge-success">@lang('Running')</span>
                                    @elseif($data->product->start_date > now() && $data->product->end_date > now())
                                        <span class="badge badge-primary">@lang('Upcoming')</span>
                                    @else
                                        <span class="badge badge-danger">@lang('Closed')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')"><a href="{{ route('auction.details', [$data->product_id, slug($data->product->name)]) }}" target="_blank" class="btn btn-default info-btn rounded"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"> @lang('No results found')!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $bids->links() }}

        </div>
    </div>
@endsection
