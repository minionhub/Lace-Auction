@php
    $category_content = getContent('category.content', true);
    if (request()->route()->getName() == 'home'){
        $categories = \App\Models\Category::active()->orderBy('name')->take(8)->get();
    } else {
        $categories = \App\Models\Category::active()->orderBy('name')->get();
    }
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Auction Categories Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="auction-categories-block ptb-120">
    <div class="container ml-b-30">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center">
                    <h2 class="title-main" data-animate="hg-fadeInUp">{{ __(@$category_content->data_values->heading) }}</h2><!-- /.title-main -->
                </div><!-- /.section-title -->
            </div><!-- /.col-lg-9 -->
        </div><!-- /.rwo -->
        <div class="row justify-content-center">

            @forelse($categories as $item)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('category.products', [$item->id, slug($item->name)]) }}" class="single-auction-cat">
                        <div class="cat-icon">
                            <span>@php echo @$item->icon @endphp</span>
                        </div>
                        <h2 class="cat-name">{{ __(@$item->name) }}</h2>
                        <div class="cat-no">{{ @$item->products->count() }}</div>
                    </a><!-- /.single-auction-cat -->
                </div><!-- /.col-lg-3 -->
            @empty
            @endforelse

        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.auction-categories-block -->
