@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="blog-page-block ptb-120">
        <div class="container">
            <!-- Content Row -->
            <div class="row justify-content-center">
                @forelse($blogs as $item)
                <div class="col-lg-4 col-md-6">
                    <!-- Blog Items -->
                            <article class="post bg-white-smoke">
                                <div class="post-thumb-area">
                                    <figure class="post-thumb">
                                        <a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}">
                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$item->data_values->image, '350x375') }}" alt="Blog Image"/>
                                        </a>
                                    </figure><!-- /.post-thumb -->
                                </div><!-- /.post-thumb-area -->

                                <div class="post-details p-4">
                                    <div class="entry-header">
                                        <div class="entry-meta-content">
                                            <div class="entry-author">{{ @$item->views }} - @lang('View')</div>
                                            <div class="entry-date">{{ showDateTime($item->created_at) }}</div>
                                        </div><!-- /.entry-meta-content -->
                                        <h2 class="entry-title"><a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a></h2><!-- /.entry-title -->
                                    </div><!-- /.entry-header -->
                                    <div class="entry-title-area">
                                        <p>{{ __(@shortDescription($item->data_values->short_description)) }}</p>
                                        <a class="read-more" href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}">@lang('Read More')</a>
                                    </div><!-- /.entry-title-area -->
                                </div><!-- /.post-details -->
                            </article><!-- /.post -->


                <!--~~~~~ Start Paging Navigation ~~~~~-->

                </div><!--  /.col-lg-8 -->
                @empty
                @endforelse

            </div><!--  /.row -->
            <div class="row justify-content-center">
                {{ $blogs->links() }}
            </div>
        </div><!--  /.container -->
    </div><!--~~./ end blog page ~~-->
@endsection
