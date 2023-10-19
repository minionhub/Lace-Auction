@php
    $faq_content = getContent('faq.content', true);
    $faq_elements = getContent('faq.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Faqs Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="faqs-block ptb-120">
    <div class="container">
        <div class="row flex-wrap-reverse">
            <div class="col-lg-6">
                <div class="faq-thumb md-mrt-55" data-animate="hg-fadeInLeft">
                    <img src="{{ getImage('assets/images/frontend/faq/' . @$faq_content->data_values->image, '464x358') }}" alt="Thumbnail">
                </div>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="faq-wrapper ml-b-15">

                    @forelse($faq_elements as $item)
                        <div class="faq-item {{ $loop->first ? 'open active' : null }}">
                            <div class="faq-title">
                                <span class="icon-file-text"></span>
                                <h4 class="title">{{ __(@$item->data_values->question) }}</h4>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>{{ __(@$item->data_values->answer) }}</p>
                            </div>
                        </div><!-- /.faq-item -->
                    @empty
                    @endforelse

                </div><!-- /.faq-wrapper -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!--~~./ end faqs block ~~-->
