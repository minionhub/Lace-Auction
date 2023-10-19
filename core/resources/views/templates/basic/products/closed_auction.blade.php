@extends($activeTemplate.'layouts.frontend')

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Closed Auction Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="closed-auction-block bg-white-smoke ptb-120">
    <div class="container ml-b-30">
        <div class="row justify-content-center">

            @forelse($expired_products as $item)

                <div class="col-lg-4 col-md-6">
                    <div class="auction-item style-three">
                        <div class="item-header">
                            <h3 class="heading"><a href="{{ route('auction.details', [$item->id, slug($item->name)]) }}">{{ __(@$item->name) }}</a></h3>
                            <div class="auction-id">{{ __(@$item->category->name) }}</div>
                        </div><!-- /.item-header -->
                        <div class="item-img">
                            <a href="{{ route('auction.details', [$item->id, slug($item->name)]) }}">
                                @forelse($item->images as $image)
                                    @if($loop->first)
                                        <img src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}" alt="Thumbnail">
                                    @endif
                                    @if($loop->iteration == 2)
                                        <img class="prod2" src="{{ getImage(imagePath()["products"]["path"] . "/" . $image) }}" alt="Thumbnail">
                                    @endif
                                @empty
                                @endforelse
                            </a>

                            @if($item->winner->bid->bid_amount)
                                <div class="item-price">@lang('Won Price'): {{ $general->cur_sym }} {{ getAmount($item->winner->bid->bid_amount) }}</div>
                            @else
                                <div class="item-price">@lang('Min Price'): {{ $general->cur_sym }} {{ getAmount($item->min_bid_price) }}</div>
                            @endif
                        </div><!-- /.item-img -->
                        <div class="item-footer">
                            <div class="item-footer-top">
                                <div class="bid-status">@lang('Closed')</div>
                                <div class="bid-winner">{{ $item->winner->user->fullname }}</div>
                            </div>
                        </div><!-- /.item-footer -->
                    </div><!-- /.auction-item -->
                </div><!-- /.col-lg-4 -->
            @empty
                <h3>@lang('No Closed Products')</h3>
            @endforelse

        </div><!-- /.row -->

        <div class="d-flex justify-content-center">
            {{ $expired_products->links() }}
        </div>
    </div>
</div><!-- /.closed-auction-block -->
@endsection
