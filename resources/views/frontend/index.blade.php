@extends('frontend.layouts.app')
@section('title') {{ 'Home' }} @endsection
@section('content')



<!-- hero area -->
<div class="hero-section">
    <div class="hero-single">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6">
                    <div class="hero-content">
                        <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">
                            <i class="far fa-truck-container"></i>Trusted & On-Time Delivery
                        </h6>
                        <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                            Khandelwal Roadlines – Your Reliable <span>Transport Partner</span> Across India
                        </h1>
                        <p data-animation="fadeInLeft" data-delay=".75s">
                            With decades of experience in logistics, we provide seamless, safe, and
                            cost-effective transport services tailored to your business needs.
                        </p>
                        <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                            <a href="about.html" class="theme-btn">About Us<i
                                    class="fas fa-arrow-right"></i></a>
                            <a href="contact.html" class="theme-btn2">Get In Touch<i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="hero-img">
                        <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                            <i class="fas fa-play"></i>
                        </a>
                        
                        <img src="{{asset('frontend/img/truck.jpg')}}" alt="Khandelwal Roadlines Truck">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- hero area end -->



<!-- feature area -->
<div class="feature-area fta-2 fa-negative">
    <div class="container">
        <div class="feature-wrap">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-item">
                            <span class="count">01</span>
                            <div class="feature-icon">
                                <img src="{{asset('frontend/img/icon/delivery.svg')}}"  alt="">
                            </div>
                            <div class="feature-content">
                                <h4>Timely Deliveries</h4>
                                <p>At Khandelwal Roadlines, we ensure your goods are delivered on time, every
                                    time, across India.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-item">
                            <span class="count">02</span>
                            <div class="feature-icon">
                                <img src="{{asset('frontend/img/icon/money.svg')}}" alt="">
                            </div>
                            <div class="feature-content">
                                <h4>Cost-Effective Logistics</h4>
                                <p>We offer competitive pricing without compromising on quality or reliability
                                    in our transport services.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-item">
                            <span class="count">03</span>
                            <div class="feature-icon">
                                
                                <img src="{{asset('frontend/img/icon/warehouse.svg')}}"  alt="">
                            </div>
                            <div class="feature-content">
                                <h4>Secure Warehousing</h4>
                                <p>Our warehousing facilities are built to keep your cargo safe and accessible
                                    throughout the transit cycle.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- feature area end -->





<!-- about area -->
<div class="about-area py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                    <div class="about-img">
                        <div class="row g-0">
                            <div class="col-4">
                                <img class="img-1" 
                                src="{{asset('frontend/img/about/01.jpg')}}"
                                alt="Khandelwal Roadlines Logistics">
                            </div>
                            <div class="col-4">
                                <img class="img-2" src="{{asset('frontend/img/about/02.jpg')}}"
                                
                                    alt="Reliable Transport Partner">
                            </div>
                            <div class="col-4">
                                <img class="img-3" src="{{asset('frontend/img/about/03.jpg')}}" alt="Fleet and Warehousing">
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
                    <a href="about.html" class="theme-btn">Discover More<i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about area end -->



<!-- service area -->
<div class="service-area sa-bg pt-80 pb-90">
    <div class="container">
        <div class="row g-4 align-items-center wow fadeInDown" data-wow-delay=".25s">
            <div class="col-lg-6">
                <div class="site-heading mb-0">
                    <span class="site-title-tagline"><i class="far fa-truck-container"></i> Services</span>
                    <h2 class="site-title text-white">What Services we <span>provide</span> at Khandelwal
                        Roadlines</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <p class="text-white">
                    At Khandelwal Roadlines, we provide reliable, timely, and cost-effective logistics and
                    transport solutions tailored to your business needs, backed by decades of experience and a
                    trusted fleet.
                </p>
            </div>

        </div>
        <div class="row g-4 mt-4 wow fadeInUp" data-wow-delay=".25s">
            <div class="col-md-6 col-lg-3">
                <div class="service-item">
                    <span class="count">01</span>
                    <div class="service-icon">
                        <img src="{{asset('frontend/img/icon/road.svg')}}" alt="">
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">
                            <a href="#">Full Truckload Services</a>
                        </h4>
                        <p class="service-text">
                            We provide end-to-end full truckload transportation across India with dedicated
                            vehicles for your cargo.
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-item">
                    <span class="count">02</span>
                    <div class="service-icon">
                        <img src="{{asset('frontend/img/icon/warehouse.svg')}}"  alt="">
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">
                            <a href="#">Storage & Warehousing</a>
                        </h4>
                        <p class="service-text">
                            Safe and secure short-term and long-term warehousing solutions to support seamless
                            logistics operations.
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-item">
                    <span class="count">03</span>
                    <div class="service-icon">
                        <img src="{{asset('frontend/img/icon/package.svg')}}" alt="">
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">
                            <a href="#">Parcel & Part Load Delivery</a>
                        </h4>
                        <p class="service-text">
                            Flexible and economical part-load delivery options for businesses of all sizes, with
                            assured delivery timelines.
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-item">
                    <span class="count">04</span>
                    <div class="service-icon">
                        <img src="{{asset('frontend/img/icon/road.svg')}}" alt="">
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">
                            <a href="#">GPS Tracking & Support</a>
                        </h4>
                        <p class="service-text">
                            All our vehicles are equipped with real-time GPS tracking to ensure transparency,
                            safety, and live status updates.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- service area end -->


<!-- process area -->
<div class="process-area py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center wow fadeInDown" data-wow-delay=".25s">
                    <span class="site-title-tagline"><i class="far fa-truck-container"></i> Working
                        Process</span>
                    <h2 class="site-title">How Khandelwal Roadlines Works</h2>
                    <div class="heading-divider"></div>
                </div>
            </div>
        </div>
        <div class="process-wrap wow fadeInUp" data-wow-delay=".25s">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="process-item">
                        <span class="count">01</span>
                        <div class="icon">
                            <img src="{{asset('frontend/img/icon/pickup.svg')}}" alt="">
                        </div>
                        <div class="content">
                            <h4>Booking & Scheduling</h4>
                            <p>Clients can easily schedule pickups and deliveries through our streamlined
                                booking system with dedicated support.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="process-item">
                        <span class="count">02</span>
                        <div class="icon">
                            <img src="{{asset('frontend/img/icon/warehouse-2.svg')}}" alt="">
                        </div>
                        <div class="content">
                            <h4>Loading & Inventory Check</h4>
                            <p>We ensure secure and efficient loading while maintaining proper records of
                                inventory for safe transit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="process-item">
                        <span class="count">03</span>
                        <div class="icon">
                            <img src="{{asset('frontend/img/icon/package.svg')}}" alt="">
                        </div>
                        <div class="content">
                            <h4>Transit & Real-Time Updates</h4>
                            <p>Our fleet is GPS-enabled for real-time tracking, ensuring timely updates and full
                                transparency during transit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="process-item">
                        <span class="count">04</span>
                        <div class="icon">
                        <img src="{{asset('frontend/img/icon/transportation.svg')}}" alt="">
                            
                        </div>
                        <div class="content">
                            <h4>Delivery & Feedback</h4>
                            <p>Goods are delivered safely and on time. We value feedback to continuously enhance
                                our logistics solutions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- process area end -->


<!-- portfolio area -->
<div class="portfolio-area py-120">
    <div class="pa-bg" style="background-image: url{{asset('frontend/img/portfolio/bg.jpg')}}"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center">
                    <span class="site-title-tagline"><i class="far fa-truck-container"></i> Our Portfolio</span>
                    <h2 class="site-title text-white">Explore Khandelwal Roadlines in Action</h2>
                </div>
            </div>
        </div>
        <div class="row popup-gallery">
            <div class="portfolio-slider owl-carousel">
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <img class="img-fluid" src="{{asset('frontend/img/portfolio/01.jpg')}}"  alt="">
                        <a class="popup-img portfolio-link" href="{{asset('frontend/img/portfolio/01.jpg')}}"> 
                            <i class="far fa-plus"></i></a>
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-info">
                            <small>Fleet Service</small>
                            <h4><a href="#">Heavy Vehicle Transport</a></h4>
                        </div>

                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <img class="img-fluid" src="{{asset('frontend/img/portfolio/02.jpg')}}"  alt="">
                        <a class="popup-img portfolio-link" href="{{asset('frontend/img/portfolio/02.jpg')}}"> <i
                                class="far fa-plus"></i></a>
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-info">
                            <small>Logistics</small>
                            <h4><a href="#">Route & Load Planning</a></h4>
                        </div>

                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <img class="img-fluid" src="{{asset('frontend/img/portfolio/03.jpg')}}" alt="">
                        <a class="popup-img portfolio-link" href="{{asset('frontend/img/portfolio/03.jpg')}}"> <i
                                class="far fa-plus"></i></a>
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-info">
                            <small>Warehousing</small>
                            <h4><a href="#">Temporary Goods Storage</a></h4>
                        </div>

                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <img class="img-fluid" src="{{asset('frontend/img/portfolio/04.jpg')}}" alt="">
                        <a class="popup-img portfolio-link" href="{{asset('frontend/img/portfolio/04.jpg')}}"> <i
                                class="far fa-plus"></i></a>
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-info">
                            <small>Delivery Network</small>
                            <h4><a href="#">All-India Coverage</a></h4>
                        </div>

                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <img class="img-fluid" src="{{asset('frontend/img/portfolio/05.jpg')}}" alt="">
                        <a class="popup-img portfolio-link" href="{{asset('frontend/img/portfolio/05.jpg')}}"> <i
                                class="far fa-plus"></i></a>
                    </div>
                    <div class="portfolio-content">
                        <div class="portfolio-info">
                            <small>Customer Satisfaction</small>
                            <h4><a href="#">Trusted by Industries</a></h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- portfolio area end -->





<!-- counter area -->
<div class="counter-area pt-40 pb-40">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="counter-box wow fadeInUp" data-wow-delay=".25s">
                    <div class="icon">
                        <img src="{{asset('frontend/img/icon/transportation.svg')}}" alt="">
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
                        <img src="{{asset('frontend/img/icon/rating.svg')}}" alt="">
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
                        <img src="{{asset('frontend/img/icon/staff.svg')}}" alt="">
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
                        <img src="{{asset('frontend/img/icon/award.svg')}}" alt="">
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





<!-- video area -->
<div class="video-area mt-100"  style="background-image: url{{asset('frontend/img/video/01.jpg')}};">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="video-wrap">
                    <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- video area end -->


<!-- quote area -->
<div class="quote-area qa-negative">
    <div class="container">
        <div class="quote-content">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="quote-form">
                        <div class="quote-header">
                            <h4>Request A Quote</h4>
                        </div>
                        <h5 class="mb-10">Personal Info</h5>
                        <form action="#">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-user-tie"></i>
                                            <input type="text" class="form-control" placeholder="Name" name="firstname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-phone"></i>
                                            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mt-20 mb-10">Shipment Info</h5>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="shipmntindo" class="select">
                                            <option value="">Freight Type</option>
                                            <option value="1">Freight Type 01</option>
                                            <option value="2">Freight Type 02</option>
                                            <option value="3">Freight Type 03</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="City Departure" name="citydeparture" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Delivery City" name="deliverycity" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="select" name="incoterms">
                                            <option value="">Incoterms</option>
                                            <option value="1">Incoterms 01</option>
                                            <option value="2">Incoterms 02</option>
                                            <option value="3">Incoterms 03</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Weight" name="weight" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Height" name="height" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Width" name="width" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Length" name="length" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="" id="shipment1" name="shipment1" required>
                                        <label class="form-check-label" for="shipment1">
                                            Fragile
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="" id="shipment2" name="shipment2" required>
                                        <label class="form-check-label" for="shipment2">
                                            Express Delivery
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="" id="shipment3" name="shipment3">
                                        <label class="form-check-label" for="shipment3">
                                            Insurance
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="" id="shipment4" name="shipment4">
                                        <label class="form-check-label" for="shipment4">
                                            Packaging
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="theme-btn"><span
                                            class="far fa-paper-plane"></span> Request A Quote</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="quote-img">
                        <img src="{{asset('frontend/img/quote/01.jpg')}}"  alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- quote area end -->




<!-- cta area -->
<div class="cta-area mt-100" style="background-image: url={{asset('frontend/img/cta/01.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="cta-content wow fadeInUp" data-wow-delay=".25s">
                    <h1>Reliable Logistics & Transportation Solutions</h1>
                    <p>At Khandelwal Roadlines, we specialize in efficient, safe, and timely delivery of goods
                        across India — trusted by businesses for over a decade.</p>
                    <a href="contact.html" class="theme-btn">Contact Now<i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cta area end -->

<!-- choose area -->
<div class="choose-area py-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                    <div class="site-heading mb-0">
                        <span class="site-title-tagline"><i class="fas fa-truck-container"></i> Why Choose
                            Us</span>
                        <h2 class="site-title">We deliver expertise you can trust in <span>transport
                                services</span></h2>
                        <p>
                            At Khandelwal Roadlines, we provide reliable and timely transportation solutions
                            across India, backed by decades of experience and a customer-first approach.
                        </p>
                    </div>
                    <div class="choose-content-wrap">
                        <div class="choose-item">
                            <div class="choose-item-icon">
                                <img src="{{asset('frontend/img/icon/money.svg')}}" alt="">
                            </div>
                            <div class="choose-item-info">
                                <h4>Competitive Pricing</h4>
                                <p>We offer affordable and transparent pricing, ensuring cost-effective
                                    transport solutions without compromising on quality or safety.</p>
                            </div>
                        </div>
                        <div class="choose-item">
                            <div class="choose-item-icon">
                                <img src="{{asset('frontend/img/icon/team.svg')}}"  alt="">
                            </div>
                            <div class="choose-item-info">
                                <h4>Experienced Fleet Operators</h4>
                                <p>Our team of trained drivers and logistics professionals ensures smooth, safe,
                                    and efficient delivery of goods across diverse terrains and cities.</p>
                            </div>
                        </div>
                        <div class="choose-item">
                            <div class="choose-item-icon">
                                <img src="{{asset('frontend/img/icon/certified.svg')}}" alt="">
                            </div>
                            <div class="choose-item-info">
                                <h4>Pan-India Reach</h4>
                                <p>We operate across all major states in India, supported by a robust network
                                    and a strong commitment to on-time delivery and customer satisfaction.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="choose-img wow fadeInRight" data-wow-delay=".25s">
                    <img class="img-1" src="{{asset('frontend/img/choose/01.jpg')}}" alt="">
                    <img class="img-2" src="{{asset('frontend/img/choose/02.jpg')}}" alt="">
                    <img class="img-shape" src="{{asset('frontend/img/choose/03.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- choose area end -->




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
                    <a href="{{ route('front.contact') }}" class="theme-btn mt-30">Know More <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">

                    <div class="testimonial-item">
                        <div class="testimonial-quote">
                            <span class="testimonial-quote-icon"><i class="fal fa-quote-right"></i></span>
                            <div class="testimonial-shadow-icon">
                                <img src="{{asset('frontend/img/icon/quote.svg')}}"  alt="">
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
                                <img src="{{asset('frontend/img/icon/quote.svg')}}"  alt="">
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
<!-- testimonial-area end -->



<!-- partner area -->
<div class="partner-area pt-60 pb-60">
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