@extends('frontend.layouts.app')
@section('title') {{ 'contact' }} @endsection
@section('content')
 
 
 <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background-image: url('{{ asset('frontend/img/breadcrumb/01.jpg') }}')">
            <div class="container">
                <h2 class="breadcrumb-title">Contact Us</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- contact area -->
        <div class="contact-area py-120">
            <div class="container">
                <div class="contact-content">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="icon">
                                    <i class="fal fa-phone-volume"></i>
                                </div>
                                <div class="content">
                                    <h5>Call Us</h5>
                                    <p>+91 7272408628</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-info">
                                <div class="icon">
                                    <i class="fal fa-map-location-dot"></i>
                                </div>
                                <div class="content">
                                    <h5>Office Address</h5>
                                    <p>Khandelwal Chembers, 13, Ujjain Road, Abhinav Hotel, Opposite Abhinav Talkies,
                                        Shivaji Nagar, Itawa Dewas - 455001 (Madhya Pradesh) India</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="icon">
                                    <i class="fal fa-envelopes"></i>
                                </div>
                                <div class="content">
                                    <h5>Email Us</h5>
                                    <p><a href="" class="__cf_email__" data-cfemail="">info@khandelwalroadlines.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="contact-form-wrap">
                    <div class="row g-4">
                        <div class="col-lg-5">
                            <div class="contact-img">
                                <img src="{{asset('frontend/img/contact/01.jpg')}}"  alt="Khandelwal Roadlines Contact">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="contact-form">
                                <div class="contact-form-header">
                                    <h2>Get In Touch</h2>
                                    <p>Have a query or need transport assistance? Reach out to Khandelwal
                                        Roadlines—we're here to provide reliable and timely logistics solutions for your
                                        business needs.</p>
                                </div>
                                <div class="form-message"></div>
                                <form method="post" action="" id="contact-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-icon">
                                                    <i class="far fa-user-tie"></i>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Your Name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-icon">
                                                    <i class="far fa-envelope"></i>
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Your Email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-pen"></i>
                                            <input type="text" class="form-control" name="subject"
                                                placeholder="Your Subject" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-icon">
                                            <i class="far fa-comment-lines"></i>
                                            <textarea name="message" cols="30" rows="5" class="form-control"
                                                placeholder="Write Your Message" required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="theme-btn">Send Message <i
                                            class="far fa-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end contact area -->


        <!-- map -->
        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3673.4880150335644!2d76.04893737476863!3d22.96907531832349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3963179734e6b8e1%3A0x318eb8bc4d718223!2sKhandelwal%20Roadlines!5e0!3m2!1sen!2sin!4v1744372306489!5m2!1sen!2sin"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <!-- map end -->
         @endsection