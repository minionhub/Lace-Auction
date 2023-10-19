@php
    $upcoming_auction_content = getContent('upcoming_auction.content', true);
    $upcoming_products = \App\Models\Product::upcoming()->with('category')->latest()->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Upcomming Auction Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="upcoming-auction-block ptb-120">
    <div class="container ml-b-30">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$upcoming_auction_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div><!-- /.col-lg-9 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="upcoming-auction-main">
                    <div class="upcoming-auction-carousel carousel-nav-dots owl-carousel">

                        @forelse($upcoming_products as $item)
                            <div class="auction-item style-two">
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
                                    <div class="item-price">@lang('Minimum Price'): {{ $general->cur_sym }}{{ getAmount($item->min_bid_price) }}</div>
                                </div><!-- /.item-img -->
                                <div class="item-header">
                                    <h3 class="heading"><a href="{{ route('auction.details', [$item->id, slug($item->name)]) }}">{{ __(@$item->name) }}</a></h3>
                                    <div class="auction-id">@lang('Category'): {{ __(@$item->category->name) }}</div>
                                </div><!-- /.item-header -->
                            </div><!-- /.auction-item -->
                        @empty
                            <h3>@lang('No Upcoming Products')</h3>
                        @endforelse

                    </div><!-- /.upcoming-auction-carousel -->
                </div><!-- /.upcoming-auction-main -->
            </div>
        </div><!-- /.row -->
    </div>
</div><!-- /.upcoming-auction-block -->
