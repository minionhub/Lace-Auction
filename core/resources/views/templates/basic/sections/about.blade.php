@php
    $about_content = getContent('about.content', true);
    $about_elements = getContent('about.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start About Us Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="about-us-block ptb-120">
    <div class="container">
        <!-- Title Row -->
        <div class="row align-items-center flex-wrap-reverse">
            <div class="col-lg-5">
                <div class="rtl about--thumb">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$about_content->data_values->image, '470x535') }}" alt="About Mock" />
                </div><!-- /.mock-up-block -->
            </div><!-- /.col-lg-5 -->

            <div class="col-lg-6">
                <div class="about-text-content">
                    <div class="section-title">
                        <h2 class="title-main">{{ __(@$about_content->data_values->heading) }}</h2><!-- /.title-main -->
                    </div><!-- /.section-title -->
                    <div class="about-info-list">

                        @forelse($about_elements as $item)
                            <div class="single-info">
                                <div class="icon">
                                    <span>@php echo @$item->data_values->icon @endphp</span>
                                </div><!-- /.icon -->
                                <div class="info">
                                    <h3 class="heading">{{ __(@$item->data_values->title) }}</h3>
                                    <p>{{ __(@$item->data_values->sub_title) }}</p>
                                </div><!-- /.info -->
                            </div><!-- /.single-info -->
                        @empty
                        @endforelse

                    </div>
                </div>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!--~~./ end about us block ~~-->
