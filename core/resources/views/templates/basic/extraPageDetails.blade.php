@extends($activeTemplate.'layouts.frontend')
@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Terams Conditions Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="terams-conditions-block ptb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-info-content terams-conditions-content">

                    @php echo @$extra->data_values->content @endphp

                </div><!-- /.page-info-content -->
            </div><!-- /.col-lg-10 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!--~~./ end terams conditions block ~~-->
@endsection
