@php
    $testimonial_content = getContent('testimonial.content', true);
    $testimonial_elements = getContent('testimonial.element');
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Testimonial Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="testimonial-block bg-white-smoke ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="title-main">{{ __(@$testimonial_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div>
            <div class="col-lg-4">
                <div class="btn-links-area text-right">
                    <button class="btn-links btn-prev">
                        <span class="icon-arrows"></span>
                    </button>
                    <button class="btn-links btn-next">
                        <span class="icon-arrows-1"></span>
                    </button>
                </div><!-- /.btn-links-area -->
            </div>
        </div><!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="testimonail-carousel-main">
                    <div id="testimonail-carousel" class="owl-carousel">

                        @forelse($testimonial_elements as $item)
                            <div class="testimonial-item">
                                    <div class="icon"><span class="icon-quotes-right"></span></div>
                                <div class="client-header">
                                    <div class="client-thumb">
                                        <div class="shape-thumb">
                                            <img src="{{ getImage('assets/images/frontend/testimonial/' . @$item->data_values->image, '110x110') }}" alt="img">
                                        </div>
                                    </div><!-- /.client-thumb -->
                                </div><!-- /.client-header -->
                                <div class="details">
                                    <p>{{ __(@$item->data_values->comment) }}</p>
                                </div><!-- /.details -->
                                <div class="client-info">
                                    <h4 class="client-name">{{ __(@$item->data_values->name) }}</h4><!-- /.client-name -->
                                    <p class="client-designation">{{ __(@$item->data_values->designation) }}</p>
                                </div><!-- /.client-info -->
                            </div><!-- /.testimonial-item -->
                        @empty
                        @endforelse

                    </div><!-- /#testimonail-carousel -->
                </div><!-- /.testimonail-carousel-main -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!--~~./ end testimonial block ~~-->
