<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@include('partials.seo')

<!-- Custom Font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,700i,900&display=swap" rel="stylesheet">

    <!-- CSS
    ================================================== -->
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/meanmenu.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/simple-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer-theme-default.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome.all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    <script src="{{asset($activeTemplateTrue.'js/modernizr.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">

    <!-- Custom Color -->
    <link rel="stylesheet"
          href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)}}">

    @stack('style-lib')
    @stack('style')
</head>
<body>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Preloader
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="preloader">
        <div class="loader loader-4"></div>
    </div><!-- /preloader -->

<!--********************************************************-->
<!--********************* SITE CONTENT *********************-->
<!--********************************************************-->
<div class="site-content">

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Site Header
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @php
        $address_content = getContent('address.content', true);
        $address_elements = getContent('address.element');
    @endphp
    <header class="site-header">
        <div class="header-top-navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="top-navbar-left">
                            <ul class="info">
                                <li class="info-date"><span class="fa fa-envelope"></span> @lang('Email'): <a
                                        href="mailto:{{ @$address_content->data_values->email }}">{{ @$address_content->data_values->email }}</a>
                                </li>
                                <li class="temperature"><span class="fa fa-phone"></span>@lang('Call Us')
                                    : {{ @$address_content->data_values->phone }} </li>
                                <li>
                                    <span class="fa fa-globe"></span>
                                    <select class="langSel border-0 bg-transparent text-muted" >
                                        <option value="">@lang('Select One')</option>
                                        @foreach($language as $item)
                                            <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div><!--~./ top-navbar-left ~-->
                    </div>
                    <div class="col-lg-5">
                        <div class="top-navbar-right">
                            <div class="header-social-area">
                                <ul class="header-social-share">
                                    @forelse($address_elements as $item)
                                        <li>
                                            <a href="{{ @$item->data_values->social_url }}">@php echo @$item->data_values->social_icon @endphp</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul><!--~./ social-share ~-->
                            </div>
                            <div class="user-registration-area">
                                <a class="user-reg-btn" href="{{ route('user.profile-setting') }}">
                                    <span class="icon-user-1"></span>
                                    {{ auth()->user()->username }}
                                </a>
                            </div>
                        </div><!--~./ top-navbar-right ~-->
                    </div>
                </div>
            </div>
        </div><!-- /.header-top-navbar -->

        <div class="site-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar navbar-expand-lg navigation-area">
                            <!-- Site Branding -->
                            <div class="site-branding">
                                <a class="site-logo" href="{{ route('home') }}">
                                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}"
                                         width="186px" alt="Site Logo"/>
                                </a>
                            </div><!-- /.site-branding -->
                            <div class="mainmenu-area">
                                <nav class="menu">
                                    <ul id="nav">
                                        <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>

                                        <li class="dropdown-trigger">
                                            <a href="javascript:void(0)">@lang('Deposit')</a>
                                            <ul class="dropdown-content">
                                                <li><a href="{{ route('user.deposit') }}">@lang('Deposit Money')</a></li>
                                                <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit Log')</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="{{ route('user.winning.products') }}">@lang('Winning Products')</a></li>
                                        <li><a href="{{ route('user.bids.list') }}">@lang('My Bids')</a></li>
                                        <li><a href="{{ route('user.referrals') }}">@lang('Referrals')</a></li>
                                        <li><a href="{{ route('user.transactions.history') }}">@lang('Transactions')</a></li>

                                        <li class="dropdown-trigger">
                                            <a href="javascript:void(0)">@lang('Ticket')</a>
                                            <ul class="dropdown-content">
                                                <li><a href="{{ route('ticket.open') }}">@lang('Create New')</a></li>
                                                <li><a href="{{ route('ticket') }}">@lang('My Ticket')</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown-trigger">
                                            <a href="javascript:void(0)">@lang('Account')</a>
                                            <ul class="dropdown-content">
                                                <li><a href="{{ route('user.change-password') }}">@lang('Change Password')</a></li>
                                                <li><a href="{{ route('user.profile-setting') }}">@lang('Profile Setting')</a></li>
                                                <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                                <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                                            </ul>
                                        </li>

                                    </ul> <!-- /.menu-list -->
                                </nav><!--/.menu-->
                            </div><!--~./ mainmenu-wrap ~-->
                        </div><!--~./ navigation-area ~-->
                    </div><!--  /.col-12 -->
                </div><!--  /.row -->
            </div>
        </div><!-- /.site-navigation -->

        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!--~~~~~~~ Start Mobile Menu ~~~~~~~~-->
                        <div class="mobile-menu">
                            <a class="mobile-logo" href="{{ route('home') }}">
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                            </a>
                        </div><!--~~./ end mobile menu ~~-->
                    </div><!--  /.col-12 -->
                </div><!--  /.row -->
            </div><!-- /.container -->
        </div><!-- /.mobile-menu-area -->
    </header><!--~~./ end site header ~~-->
    <!--~~~ Sticky Header ~~~-->
    <div id="sticky-header"></div><!--~./ end sticky header ~-->

    <!--breadcrumb area-->
    @include($activeTemplate.'partials.breadcrumb')
    <!--/breadcrumb area-->



    @yield('content')



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Site Footer
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @php
        $footer_content = getContent('footer.content', true);
        $copyright_content = getContent('copyright.content', true);
        $terms_privacy = getContent('extra.element');
        $blogs = getContent('blog.element', false, 3);
    @endphp
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Footer Widget Area
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <footer class="site-footer pd-t-120">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Footer Widget Area
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div class="footer-widget-area">
            <div class="container">
                <div class="row">
                    <!--~~~~~ Start Widget About us ~~~~~-->
                    <div class="col-lg-4">
                        <aside class="widget widget_about">
                            <h2 class="widget-title">@lang('About Us')</h2>
                            <div class="widget-content">
                                <p>{{ __(@$footer_content->data_values->content) }}</p>
                            </div>
                        </aside>
                    </div><!--~./ end about us widget ~-->

                    <!--~~~~~ Start Widget Links ~~~~~-->
                    <div class="col-lg-2">
                        <aside class="widget widget_links">
                            <h2 class="widget-title">@lang('Quick Link')</h2>
                            <div class="widget-content">
                                <ul>
                                    @foreach($pages as $k => $data)
                                        <li><a href="{{route('pages',[$data->slug])}}">
                                                {{trans($data->name)}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div><!--~./ end links widget ~-->

                    <!--~~~~~ Start Widget Links ~~~~~-->
                    <div class="col-lg-2">
                        <aside class="widget widget_links">
                            <h2 class="widget-title">@lang('Help Center')</h2>
                            <div class="widget-content">
                                <ul>

                                    @forelse($terms_privacy as $item)
                                        <li>
                                            <a href="{{ route('extraPage.details', [$item->id, slug($item->data_values->title)]) }}">
                                                @lang($item->data_values->title)
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse

                                    <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                                </ul>
                            </div>
                        </aside>
                    </div><!--~./ end links widget ~-->

                    <!--~~~~~ Start Widget Links ~~~~~-->
                    <div class="col-lg-4">
                        <aside class="widget widget_payment">
                            <h2 class="widget-title">@lang('Contact Info')</h2>
                            <div class="widget-content">
                                <div class="contact-info">
                                        <div class="icon">
                                            <span class="icon-paperplane"></span>
                                        </div>
                                        <div class="info">
                                            <p>{{ __(@$address_content->data_values->address) }}</p>
                                        </div>
                                    </div><!-- /.contact-info -->
                                    <div class="contact-info">
                                        <div class="icon">
                                            <span class="icon-phone2"></span>
                                        </div>
                                        <div class="info">
                                            <p>{{ @$address_content->data_values->phone }}</p>
                                        </div>
                                    </div><!-- /.contact-info -->
                                    <div class="contact-info">
                                        <div class="icon">
                                            <span class="icon-mail5"></span>
                                        </div>
                                        <div class="info">
                                            <p>
                                                <a href="mailto:{{ @$address_content->data_values->email }}">{{ @$address_content->data_values->email }}</a>
                                            </p>
                                        </div>
                                    </div><!-- /.contact-info -->
                            </div>
                        </aside>
                    </div><!--~./ end payment widget ~-->
                </div>
            </div>
        </div><!--~./ end footer widgets area ~-->

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Footer Bottom Area
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div class="container">
            <div class="footer-bottom d-flex flex-wrap-reverse justify-content-between align-items-center py-3">
                <div class="copyright-text text-center">
                    <div class="copyright text-white">
                        {{ __(@$copyright_content->data_values->content) }}
                    </div>
                </div>
                <ul class="social-icons">
                    @forelse($address_elements as $item)
                        <li>
                            <a href="{{ @$item->data_values->social_url }}">@php echo @$item->data_values->social_icon @endphp</a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </footer>

</div><!--~~./ end site content ~~-->

<!-- All The JS Files
    ================================================== -->
<script src="{{asset($activeTemplateTrue.'js/jquery.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/popper.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/plugins.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/meanmenu.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/particles.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/theia-sticky-sidebar.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/ResizeSensor.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/simple-scrollbar.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/scrolla.jquery.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/isInViewport.jquery.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/yscountdown.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/owl.carousel.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script><!-- main-js -->

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('admin.partials.notify')


<script>
    (function ($) {
        "use strict";
        $(document).on("change", ".langSel", function () {
            window.location.href = "{{url('/')}}/change/" + $(this).val();
        });
    })(jQuery);
</script>

</body>
</html>
