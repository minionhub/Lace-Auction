@extends($activeTemplate.'layouts.frontend')
@section('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Blog Page Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="blog-page-block ptb-120">
        <div class="container">
            <!-- Content Row -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Blog Items -->
                    <div class="blog-latest-items blog-single-page">
                        <article class="post single-post">
                            <h2 class="entry-title">{{ __(@$blog->data_values->title) }}</h2><!-- /.entry-title -->


                            <div class="post-details">
                                <figure class="thumb">
                                    <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image,'900x500') }}" class="w-100" alt="Img">
                                </figure>
                                <div class="entry-content">

                                    @php echo @$blog->data_values->description @endphp

                                </div><!-- /.entry-content -->
                            </div><!-- /.post-details -->
                        </article><!-- /.post -->


                        @if(\App\Models\Extension::where('act', 'fb-comment')->where('status', 1)->first())
                            <div class="comment-respond">
                                <h3 class="comment-reply-title">@lang('Leave A Comment')</h3>
                                <div class="row">
                                    <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
                                </div><!-- /.row -->
                            </div>
                        @endif

                    </div><!--  /.blog-latest-items -->
                </div><!-- /.col-lg-9 -->

                <div class="col-lg-4">
                    <!-- Sidebar Items -->
                    <div class="sidebar-items">

                        <!--~~~~~ Start Post List Widget~~~~~-->
                        <aside class="widget widget-post-list">
                            <h4 class="widget-title">@lang('Latest Live Auction')</h4><!-- /.widget-title -->

                            <div class="widget-content">

                                @forelse($latest_blogs as $item)
                                    <article class="post">
                                        <div class="post-thumb">
                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$item->data_values->image, '350x375') }}" alt="Thumbnail">
                                        </div>
                                        <div class="post-details">
                                            <h3 class="entry-title">
                                                <a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a>
                                            </h3><!--./ entry-title -->
                                            <div class="entry-meta-content">
                                                <div class="entry-date">
                                                    <span class="icon-clock1"></span>
                                                    {{ __(@showDateTime($item->created_at)) }}
                                                </div><!--./ entry-date -->
                                            </div><!--./ entry-meta-content -->
                                        </div>
                                    </article><!--./ end post -->
                                @empty
                                    <h5>@lang('No Data')</h5>
                                @endforelse

                            </div>
                        </aside><!--~./ end post list widget ~-->

                    </div><!--  /.sidebar-items -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!--  /.container -->
    </div><!--~~./ end blog page ~~-->
@endsection
