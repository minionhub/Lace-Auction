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
                                <th scope="col">@lang('Shipping Status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($winners as $item)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($item->created_at) }}</td>
                                    <td data-label="@lang('User')">
                                        <div class="user justify-content-lg-center justify-content-end">
                                            <div class="thumb">
                                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$item->user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')">
                                            </div>
                                            <a href="{{ route('admin.users.detail', $item->user_id) }}" class="ml-2">{{$item->user->fullname}}</a>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Product')">{{ $item->bid->product->name }}</td>

                                    <td data-label="@lang('Order Status')">
                                        <select class="changeStatus bg--{{ $item->shipping_status == 0 ? 'primary' : ($item->shipping_status == 1 ? 'info' : 'success') }}" name="status">
                                            <option item_url="{{ route('admin.winners.status.update', $item->id) }}"
                                                    value="0" {{ $item->shipping_status == 0 ? 'selected' : null }}>@lang('Pending')</option>
                                            <option item_url="{{ route('admin.winners.status.update', $item->id) }}"
                                                    value="1" {{ $item->shipping_status == 1 ? 'selected' : null }}>@lang('Processing')</option>
                                            <option item_url="{{ route('admin.winners.status.update', $item->id) }}"
                                                    value="2" {{ $item->shipping_status == 2 ? 'selected' : null }}>@lang('Shipped')</option>
                                        </select>
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
                <div class="card-footer">
                    {{ paginateLinks($winners) }}
                </div>
            </div><!-- card end -->
        </div>

    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            // Order status update
            $(document).on("change", ".changeStatus", function () {
                var url = $('option:selected', this).attr('item_url');
                window.location.href = url + '?status=' + $(this).val();
            });
        })(jQuery);
    </script>
@endpush
