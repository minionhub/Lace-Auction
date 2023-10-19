@extends($activeTemplate.'layouts.master')

@section('content')
    <div class=" ptb-120">
        <div class="container ml-b-30">

            <div class="table-responsive custom-box-shadow">
                <table class="table custom--table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Subject')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Last Reply')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($supports as $key => $support)
                        <tr>
                            <td data-label="@lang('Subject')"><a href="{{ route('ticket.view', $support->ticket) }}"
                                                                 class="font-weight-bold">
                                    [Ticket#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                            <td data-label="@lang('Status')">
                                @if($support->status == 0)
                                    <span class="badge badge-success">@lang('Open')</span>
                                @elseif($support->status == 1)
                                    <span class="badge badge-primary">@lang('Answered')</span>
                                @elseif($support->status == 2)
                                    <span class="badge badge-warning">@lang('Customer Reply')</span>
                                @elseif($support->status == 3)
                                    <span class="badge badge-dark">@lang('Closed')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                            <td data-label="@lang('Action')">
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-default info-btn">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$supports->links()}}

        </div>
    </div>
@endsection
