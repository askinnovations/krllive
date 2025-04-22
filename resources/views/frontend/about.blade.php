@extends('frontend.layouts.app')
@section('title') {{ 'about' }} @endsection
@section('content')


    <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background-image: url('{{ asset('frontend/img/breadcrumb/01.jpg') }}')">
            <div class="container">
                <h2 class="breadcrumb-title">About Us</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->
        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img class="img-1" src="{{asset('frontend/img/about/01.jpg')}}" 
                                            alt="Khandelwal Roadlines Logistics">
                                    </div>
                                    <div class="col-4">
                                        <img class="img-2" src="{{asset('frontend/img/about/02.jpg')}}" 
                                            alt="Reliable Transport Partner">
                                    </div>
                                    <div class="col-4">
                                        <img class="img-3" src="{{asset('frontend/img/about/03.jpg')}}"  alt="Fleet and Warehousing">
                                    </div>
                                </div>
                            </div>
                            <div class="about-experience">
                                <h5>30<span>+</span></h5>
                                <p>Years Of Experience</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInUp" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline"><i class="far fa-truck-container"></i> About Us</span>
                                <h2 class="site-title">We Are Khandelwal Roadlines — Your Trusted <span>Logistics
                                        Partner</span></h2>
                            </div>
                            <p class="about-text">
                                Khandelwal Roadlines has been a trusted name in the logistics and transportation
                                industry for over 30 years.
                                We specialize in delivering comprehensive transport solutions across India with a strong
                                commitment to safety,
                                timeliness, and client satisfaction. Our modern fleet and experienced team ensure
                                seamless road freight movement,
                                supporting diverse industries with reliable service.
                            </p>
                            <div class="about-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="about-item">
                                            <div class="icon">
                                                <img src="{{asset('frontend/img/icon/team.svg')}}" alt="">
                                            </div>
                                            <div class="content">
                                                <h6>Experienced Team</h6>
                                                <p>Led by industry experts who understand logistics and customer
                                                    priorities.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="about-item">
                                            <div class="icon">
                                                <img src="{{asset('frontend/img/icon/support.svg')}}"  alt="">
                                            </div>
                                            <div class="content">
                                                <h6>Customer-Centric Approach</h6>
                                                <p>We prioritize clear communication and timely deliveries, 24/7.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->



        <!-- counter area -->
        <div class="counter-area pt-40 pb-40">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="counter-box wow fadeInUp" data-wow-delay=".25s">
                            <div class="icon">
                                <img src="{{asset('frontend/img/icon/transportation.svg')}}"  alt="">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <span class="counter" data-count="+" data-to="5000" data-speed="3000">5000</span>
                                    <span class="unit">+</span>
                                </div>
                                <h6 class="title">Deliveries Completed</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="counter-box wow fadeInDown" data-wow-delay=".25s">
                            <div class="icon">
                                <img src="{{asset('frontend/img/icon/rating.svg')}}"  alt="">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <span class="counter" data-count="+" data-to="200" data-speed="3000">200</span>
                                    <span class="unit">+</span>
                                </div>
                                <h6 class="title">Trusted <br> Clients</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="counter-box wow fadeInUp" data-wow-delay=".25s">
                            <div class="icon">
                                <img src="{{asset('frontend/img/icon/staff.svg')}}"  alt="">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <span class="counter" data-count="+" data-to="80" data-speed="3000">80</span>
                                    <span class="unit">+</span>
                                </div>
                                <h6 class="title">Experienced Staff</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="counter-box wow fadeInDown" data-wow-delay=".25s">
                            <div class="icon">
                                <img src="{{asset('frontend/img/icon/award.svg')}}"  alt="">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <span class="counter" data-count="+" data-to="15" data-speed="3000">15</span>
                                    <span class="unit">+</span>
                                </div>
                                <h6 class="title">Years in Logistics</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter area end -->



        <!-- skill-area -->
        <div class="skill-area py-120">
            <div class="container">
                <div class="skill-wrap">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="skill-img wow fadeInLeft" data-wow-delay=".25s">
                                <img src="{{asset('frontend/img/truck.jpg')}}" alt="Khandelwal Logistics">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="skill-content wow fadeInUp" data-wow-delay=".25s">
                                <span class="site-title-tagline"><i class="far fa-truck-container"></i> Our
                                    Expertise</span>
                                <h2 class="site-title">Trusted Name in <span>Road Transport</span> & Logistics</h2>
                                <p class="skill-text">
                                    At Khandelwal Roadlines, we bring decades of experience in delivering reliable and
                                    efficient transport solutions. Our commitment to timely delivery, safety, and
                                    customer satisfaction has made us a trusted partner across industries.
                                </p>
                                <div class="skill-progress">
                                    <div class="progress-item">
                                        <h5>Fleet Management <span class="percent">90%</span></h5>
                                        <div class="progress" data-value="90">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>
                                    <div class="progress-item">
                                        <h5>On-Time Delivery <span class="percent">95%</span></h5>
                                        <div class="progress" data-value="95">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>
                                    <div class="progress-item">
                                        <h5>Customer Satisfaction <span class="percent">98%</span></h5>
                                        <div class="progress" data-value="98">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- skill area end -->



        <!-- testimonial-area -->
        <div class="testimonial-area ts-bg pt-80 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="site-heading wow fadeInDown" data-wow-delay=".25s">
                            <span class="site-title-tagline"><i class="fas fa-truck-container"></i> Testimonials</span>
                            <h2 class="site-title text-white">What Our Clients <span>Say</span> About Us</h2>
                            <p class="text-white">
                                We take pride in the satisfaction and trust of our clients. Here's what some of them
                                have to say about their experience with Khandelwal Roadlines.
                            </p>
                            <a href="{{ route('front.about') }}" class="theme-btn mt-30">Know More <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                            <div class="testimonial-item">
                                <div class="testimonial-quote">
                                    <span class="testimonial-quote-icon"><i class="fal fa-quote-right"></i></span>
                                    <div class="testimonial-shadow-icon">
                                        <img src="{{asset('frontend/img/icon/quote.svg')}}" alt="">
                                    </div>
                                    <p>
                                        We’ve been using Khandelwal Roadlines for over 3 years now. Their service is
                                        always on time and dependable. Highly recommended for any logistics needs.
                                    </p>
                                    <div class="testimonial-rate">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">

                                    <div class="testimonial-author-info">
                                        <h4>Rahul Mehta</h4>
                                        <p>Business Owner, Indore</p>
                                    </div>
                                </div>
                            </div>

                            <div class="testimonial-item">
                                <div class="testimonial-quote">
                                    <span class="testimonial-quote-icon"><i class="fal fa-quote-right"></i></span>
                                    <div class="testimonial-shadow-icon">
                                        <img src="{{asset('frontend/img/icon/quote.svg')}}" alt="">
                                    </div>
                                    <p>
                                        Excellent communication and professional service. Their fleet is well-maintained
                                        and the drivers are courteous and experienced.
                                    </p>
                                    <div class="testimonial-rate">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">

                                    <div class="testimonial-author-info">
                                        <h4>Sneha Sharma</h4>
                                        <p>Operations Manager, Ujjain</p>
                                    </div>
                                </div>
                            </div>

                            <div class="testimonial-item">
                                <div class="testimonial-quote">
                                    <span class="testimonial-quote-icon"><i class="fal fa-quote-right"></i></span>
                                    <div class="testimonial-shadow-icon">
                                        <img src="{{asset('frontend/img/icon/quote.svg')}}" alt="">
                                    </div>
                                    <p>
                                        Timely deliveries, affordable pricing, and reliable support – Khandelwal
                                        Roadlines is our go-to for all transport needs.
                                    </p>
                                    <div class="testimonial-rate">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">

                                    <div class="testimonial-author-info">
                                        <h4>Amit Rathore</h4>
                                        <p>Logistics Head, Dewas</p>
                                    </div>
                                </div>
                            </div>

                            <div class="testimonial-item">
                                <div class="testimonial-quote">
                                    <span class="testimonial-quote-icon"><i class="fal fa-quote-right"></i></span>
                                    <div class="testimonial-shadow-icon">
                                        <img src="{{asset('frontend/img/icon/quote.svg')}}" alt="">
                                    </div>
                                    <p>
                                        Khandelwal Roadlines has always been a reliable partner. They understand our
                                        business needs and deliver beyond expectations.
                                    </p>
                                    <div class="testimonial-rate">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="testimonial-content">

                                    <div class="testimonial-author-info">
                                        <h4>Pooja Verma</h4>
                                        <p>Supply Chain Analyst, Bhopal</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- testimonial-area end --

 


        <!-- partner area -->
        <div class="partner-area bg pt-60 pb-60">
            <div class="container">
                <div class="partner-wrapper partner-slider owl-carousel owl-theme">
                <img src="{{asset('frontend/img/partner/01.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/02.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/03.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/01.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/02.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/03.png')}}" alt="thumb">
                <img src="{{asset('frontend/img/partner/02.png')}}" alt="thumb">
                </div>
            </div>
        </div>
        <!-- partner area end -->

@endsection
