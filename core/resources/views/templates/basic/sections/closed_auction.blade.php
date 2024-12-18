@php
    $closed_auction_content = getContent('closed_auction.content', true);
    $expired_products = \App\Models\Product::expired()->with('category')->latest()->take(6)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Closed Auction Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="closed-auction-block bg-white-smoke pd-t-80 pd-b-80">
    <div class="container ml-b-30">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$closed_auction_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div><!-- /.col-lg-9 -->
        </div><!-- /.row -->

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
        <div class="text-center">
            <a href="{{ route('closedAuction') }}" class="btn btn-default">@lang('View more')</a>
        </div>
    </div>
</div><!-- /.closed-auction-block -->
