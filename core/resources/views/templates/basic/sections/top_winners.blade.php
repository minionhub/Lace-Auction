@php
    $top_winners_content = getContent('top_winners.content', true);
    $winners = \App\Models\Winner::with(['user', 'bid'])->latest()->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Auction Winner Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="auction-winner-block bg-white-smoke ptb-120">
    <div class="container ml-b-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$top_winners_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div><!-- /.col-lg-1 -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div id="winner-carousel" class="owl-carousel">

                    @forelse($winners as $item)
                        <div class="winner-item">
                            <div class="winner-thumb">
                                <img src="{{ getImage('assets/images/user/profile/'. $item->user->image,'200x200') }}" alt="img">
                                <div class="winner-auction-product">
                                    <div class="product-icon">
                                        <span class="icon-gift"></span>
                                    </div>
                                    <div class="product-thumb">
                                        @forelse($item->bid->product->images as $image)
                                            @if($loop->first)
                                                <img src="{{ getImage(imagePath()["products"]["path"] . "/" . $image, '350x500') }}"
                                                     alt="product">
                                            @endif
                                            @break;
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div><!-- /.winner-thumb -->
                            <div class="info">
                                <h4 class="winner-name">{{ $item->user->fullname }}</h4><!-- /.client-name -->
                                <p class="auction-id">@lang('Won Price'): {{ $general->cur_sym . getAmount($item->bid->bid_amount) }}</p>
                            </div><!-- /.info -->
                        </div><!-- /.winner-item -->
                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div><!-- /.container -->
</div><!--~~./ end auction winner block ~~-->
