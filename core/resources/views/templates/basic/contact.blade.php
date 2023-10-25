@extends($activeTemplate.'layouts.frontend')

@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Contact Info Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="contact-info-block ptb-120">
        <div class="container ml-b-30">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-item address" data-animate="hg-fadeInUp">
                        <div class="shape-icon">
                            <span class="icon-map2"></span>
                        </div>

                        <div class="card-info">
                            <p>{{ __(@$address_content->data_values->address) }}</p>
                        </div><!-- /.card-info -->
                    </div><!-- /.contact-info-item -->
                </div><!-- /.col-lg-4 -->

                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-item email" data-animate="hg-fadeInUp">
                        <div class="shape-icon">
                            <span class="icon-email-1"></span>
                        </div>
                        <div class="card-info">
                            <p><a href="mailto:{{ @$address_content->data_values->email }}">{{ @$address_content->data_values->email }}</a></p>
                        </div><!-- /.card-info -->
                    </div><!-- /.contact-info-item -->
                </div><!-- /.col-lg-4 -->

                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-item" data-animate="hg-fadeInUp">
                        <div class="shape-icon">
                            <span class="icon-call"></span>
                        </div>
                        <div class="card-info">
                            <p>{{ @$address_content->data_values->phone }}</p>
                        </div><!-- /.card-info -->
                    </div><!-- /.contact-info-item -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!--~~./ end contact info block ~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Contact Form Block
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="contact-form-block pd-b-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form-area">
                        <div class="section-title">
                            <h2 class="title-main hg-fadeInUp animated" data-animate="hg-fadeInUp" style="visibility: visible;">@lang('Get In Touch')</h2><!-- /.title-main -->
                        </div>
                        <form id="contact_form" class="contact-form" method="post" action="">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="name" type="text" placeholder="@lang('Your Name')" class="form-controller" value="{{ auth()->check() ? auth()->user()->fullname : old('name') }}" {{ auth()->check() ? 'readonly' : '' }} required>
                                    </div>
                                </div><!--./ col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form-controller" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" {{ auth()->check() ? 'readonly' : '' }} required>
                                    </div>
                                </div><!--./ col-lg-6 -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form-controller" value="{{old('subject')}}" required>
                                    </div>
                                </div><!-- /.col-12 -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form-controller">{{old('message')}}</textarea>
                                    </div>
                                </div><!-- /.col-12 -->
                                <div class="col-12 mrt-5">
                                    <button type="submit" class="btn btn-default">@lang('Submit now')</button>
                                </div><!--./ col-lg-6 -->
                            </div><!-- /.row -->
                        </form><!-- /.contact-form -->
                    </div><!-- /.contact-form-area -->
                </div><!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="contact-thumb md-mrt-60" data-animate="hg-fadeInLeft">
                        <img src="{{ getImage('assets/images/frontend/contact/' . @$contact_content->data_values->image, '825x642') }}" alt="Thumbnail">
                    </div>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!--~~./ end contact form block ~~-->
@endsection
