@php
    $bid_process_content = getContent('bid_process.content', true);
    $bid_process_elements = getContent('bid_process.element', false, 3);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Win Steps Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="win-steps-block ptb-150">
    <div class="container ml-b-45">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$bid_process_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div><!-- /.col-lg-1 -->
        </div><!-- /.row -->

        <div class="row">

            @forelse($bid_process_elements as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card-center">
                        <div class="card-icon">
                            <img src="{{ getImage('assets/images/frontend/bid_process/' . @$item->data_values->image, '') }}" alt="Icon">
                            <div class="step">{{ $loop->iteration }}</div>
                        </div>
                        <div class="card-info">
                            <h3 class="heading">{{ __(@$item->data_values->title) }}</h3>
                        </div><!-- /.card-info -->
                    </div><!-- /.card-center -->
                </div><!-- /.col-lg-4 -->
            @empty
            @endforelse

        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!--~~./ end win steps block ~~-->
