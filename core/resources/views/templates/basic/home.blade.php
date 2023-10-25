@extends($activeTemplate.'layouts.frontend')
@section('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Hero Block
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @php
        $hero_content = getContent('hero.content', true);
        $hero_elements = getContent('hero.element',false,null,true);
    @endphp

    <div id="hero-block" class="hero-block bg-overlay bg-image" style="background-image: url('{{ getImage('assets/images/frontend/hero/' . @$hero_content->data_values->background_image, '1920x900') }}')">
        <div class="wave-block bg-image" style="background-image: url('{{asset($activeTemplateTrue.'images/wave.png')}}')"></div>
        <div class="container">
            <div class="row align-items-center justify-content-center hero-content-main">
                <div class="col-lg-10">
                    <div class="hero-content-area text-center ptb-120">
                        <div class="hero-title-area">
                            <h2 class="hero-title"><span class="text-typed" data-elements="{{ __(@$hero_content->data_values->heading) }}"></span></h2><!-- /.hero-title -->
                        </div><!-- /.hero-title-area -->
                        <div class="hero-desc">
                            <p>{{ __(@$hero_content->data_values->sub_heading) }}</p>
                        </div><!-- /.hero-desc -->
                        <div class="form-group-btn">
                            <a class="btn btn-default" href="{{ @$hero_content->data_values->button_1_url }}">{{ __(@$hero_content->data_values->button_1) }}</a>
                            <a class="btn btn-default btn-white" href="{{ @$hero_content->data_values->button_2_url }}">{{ __(@$hero_content->data_values->button_2) }}</a>
                        </div><!-- /.form-group-btn -->
                    </div><!-- /.hero-content-area -->
                </div><!-- /.col-lg-8 -->
            </div><!--  /.row -->
        </div><!-- /.container -->
    </div><!-- /.hero-block -->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Facility Area
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="facility-area ptb-120 pb-0">
        <div class="container ml-b-30">
            <div class="row facility-content">

                @forelse($hero_elements as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="facility-box">
                            <div class="icon">
                                <span>@php echo @$item->data_values->icon @endphp</span>
                            </div>
                            <h3 class="title">{{ __(@$item->data_values->title) }}</h3>
                        </div><!-- /.facility-box -->
                    </div><!-- /.col-lg-3 -->
                @empty
                @endforelse

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.facility-area -->

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            //particle js
            if ($('#particles-js').length) {
                particlesJS('particles-js',
                    {
                        "particles": {
                            "number": {
                                "value": 80,
                                "density": {
                                    "enable": true,
                                    "value_area": 800
                                }
                            },
                            "color": {
                                "value": "#ffffff"
                            },
                            "shape": {
                                "type": "circle",
                                "stroke": {
                                    "width": 3,
                                    "color": "#{{ $general->base_color }}"
                                },
                                "polygon": {
                                    "nb_sides": 10
                                }
                            },
                            "opacity": {
                                "value": 0.6,
                                "random": false,
                                "anim": {
                                    "enable": false,
                                    "speed": 1,
                                    "opacity_min": 0.2,
                                    "sync": false
                                }
                            },
                            "size": {
                                "value": 5,
                                "random": true,
                                "anim": {
                                    "enable": false,
                                    "speed": 40,
                                    "size_min": 0.1,
                                    "sync": false
                                }
                            },
                            "line_linked": {
                                "enable": true,
                                "distance": 150,
                                "color": "#ffffff",
                                "opacity": 0.4,
                                "width": 1
                            },
                            "move": {
                                "enable": true,
                                "speed": 6,
                                "direction": "none",
                                "random": false,
                                "straight": false,
                                "out_mode": "out",
                                "attract": {
                                    "enable": false,
                                    "rotateX": 600,
                                    "rotateY": 1200
                                }
                            }
                        },
                        "interactivity": {
                            "detect_on": "canvas",
                            "events": {
                                "onhover": {
                                    "enable": true,
                                    "mode": "repulse"
                                },
                                "onclick": {
                                    "enable": true,
                                    "mode": "push"
                                },
                                "resize": true
                            },
                            "modes": {
                                "grab": {
                                    "distance": 400,
                                    "line_linked": {
                                        "opacity": 1
                                    }
                                },
                                "bubble": {
                                    "distance": 400,
                                    "size": 40,
                                    "duration": 2,
                                    "opacity": 8,
                                    "speed": 3
                                },
                                "repulse": {
                                    "distance": 200
                                },
                                "push": {
                                    "particles_nb": 4
                                },
                                "remove": {
                                    "particles_nb": 2
                                }
                            }
                        },
                        "retina_detect": true,
                        "config_demo": {
                            "hide_card": false,
                            "background_image": "{{ asset('assets/images/particle.png') }}",
                            "background_position": "50% 50%",
                            "background_repeat": "no-repeat",
                            "background_size": "cover"
                        }
                    }
                );
            }
        })(jQuery);
    </script>
@endpush
