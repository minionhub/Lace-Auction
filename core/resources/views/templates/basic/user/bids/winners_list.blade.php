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
                        <th scope="col">@lang('Shipping Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($winners as $data)
                            <tr>
                                <td data-label="@lang('Date')">{{ showDateTime($data->created_at) }}</td>
                                <td data-label="@lang('Product')"><a href="{{ route('auction.details', [$data->bid->product_id, slug($data->bid->product->name)]) }}" target="_blank">{{ __(@$data->bid->product->name)  }}</a></td>
                                <td>
                                    @if($data->shipping_status === 0)
                                        <span class="badge badge-primary">@lang('Pending')</span>
                                    @elseif($data->shipping_status === 1)
                                        <span class="badge badge-info">@lang('Processing')</span>
                                    @else
                                        <span class="badge badge-success">@lang('Shipped')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')"><a href="{{ route('auction.details', [$data->bid->product_id, slug($data->bid->product->name)]) }}" target="_blank" class="btn btn-default info-btn rounded"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"> @lang('No results found')!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $winners->links() }}

        </div>
    </div>
@endsection
