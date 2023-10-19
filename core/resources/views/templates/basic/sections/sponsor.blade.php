@php
    $sponsor_elements = getContent('sponsor.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Work brand Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="work-brand-block ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!--~~ Start Brands Carousel ~~-->
                <div class="brands-carousel-main" data-animate="hg-fadeInUp">
                    <div class="brands-carousel owl-carousel">

                        @forelse($sponsor_elements as $item)
                            <div class="brands-link">
                                <img src="{{ getImage('assets/images/frontend/sponsor/' . @$item->data_values->image, '126x80') }}" alt="logo">
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div><!--~./ end brands carousel ~-->
            </div>
        </div>
    </div>
</div><!--~./ end work brand block ~-->
