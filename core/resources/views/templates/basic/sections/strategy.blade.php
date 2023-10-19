@php
    $strategy_content = getContent('strategy.content', true);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Fan Fact Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="fanfact-block ptb-120">
    <div class="container ml-b-30">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$strategy_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div>
        </div>
        <div class="row fanfact-promo-numbers justify-content-center">
            <div class="col-sm-6 col-lg-4" data-animate="hg-fadeInUp">
                <div class="promo-number">
                    <div class="odometer-wrap"><div class="odometer" data-odometer-final="{{ @$strategy_content->data_values->strategy_number_1 }}">0</div></div><!-- /.odometer-wrap -->
                    <h4 class="promo-title">{{ __(@$strategy_content->data_values->strategy_name_1) }}</h4><!-- /.promo-title -->
                    <div class="animation-circle-inverse">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div><!-- /.animation-circle-inverse -->
                </div><!-- /.promo-number -->
            </div><!-- /.col-lg-4 -->
            <div class="col-sm-6 col-lg-4" data-animate="hg-fadeInUp">
                <div class="promo-number number-green">
                    <div class="odometer-wrap"><div class="odometer" data-odometer-final="{{ @$strategy_content->data_values->strategy_number_2 }}">0</div></div><!-- /.odometer-wrap -->
                    <h4 class="promo-title">{{ __(@$strategy_content->data_values->strategy_name_2) }}</h4><!--  /.promo-title -->
                    <div class="animation-circle-inverse">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div><!-- /.animation-circle-inverse -->
                </div><!-- /.promo-number -->
            </div><!-- /.col-lg-4 -->
            <div class="col-sm-6 col-lg-4" data-animate="hg-fadeInUp">
                <div class="promo-number number-orange">
                    <div class="odometer-wrap"><div class="odometer" data-odometer-final="{{ @$strategy_content->data_values->strategy_number_3 }}">0</div></div><!-- /.odometer-wrap -->
                    <h4 class="promo-title">{{ __(@$strategy_content->data_values->strategy_name_3) }}</h4><!--  /.promo-title -->
                    <div class="animation-circle-inverse">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div><!-- /.animation-circle-inverse -->
                </div><!-- /.promo-number -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.fanfact-promo-numbers -->
    </div><!-- /.container -->
</div><!--~~./ end fanfact block ~~-->
