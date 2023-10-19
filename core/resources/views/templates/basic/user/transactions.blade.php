@extends($activeTemplate.'layouts.master')
@section('content')
    <div class=" ptb-120">
        <div class="container ml-b-30">

            <div class="table-responsive custom-box-shadow">
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
                    @forelse($logs as $k=>$data)
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

            {{$logs->links()}}

        </div>
    </div>

@endsection
