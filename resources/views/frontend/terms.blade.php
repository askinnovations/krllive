@extends('frontend.layouts.app')
@section('title') {{ 'terms' }} @endsection
@section('content')
       <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background-image: url('{{ asset('frontend/img/breadcrumb/01.jpg') }}')">
            <div class="container">
                <h2 class="breadcrumb-title">Terms & Conditions</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Terms & Conditions</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- terms of service -->
        <div class="terms-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="terms-content">
                            <h3>Terms & Conditions</h3>
                            <p>
                                Welcome to Khandelwal Roadlines. By accessing or using our logistics and transportation
                                services, you agree to comply with the following terms and conditions. These terms
                                govern your use of our website, booking system, and any other services provided by us.
                                Please read them carefully before engaging with our services.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Service Agreement</h3>
                            <p>
                                Khandelwal Roadlines agrees to provide transportation and logistics services as per
                                mutually accepted terms between the client and our company. All services will be
                                executed professionally and in accordance with the industry standards. The scope of
                                work, timelines, and pricing will be clearly communicated and documented in each service
                                agreement.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Payment Terms</h3>
                            <p>
                                All payments must be made as per the agreed-upon schedule mentioned in the invoice or
                                contract. Late payments may incur additional charges. We accept bank transfers and other
                                standard payment methods. In case of any discrepancies or disputes regarding payments,
                                clients must notify us in writing within 7 working days.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Cancellation & Refund Policy</h3>
                            <p>
                                Cancellations must be communicated in advance. In the event of a service cancellation by
                                the client, applicable cancellation fees may be deducted based on the progress of the
                                service. Refunds, if applicable, will be processed within 14 business days after review
                                and approval.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Liability</h3>
                            <p>
                                While Khandelwal Roadlines takes utmost care in handling your goods, we are not
                                responsible for any damage or loss due to unforeseen events such as natural disasters,
                                accidents, theft, or circumstances beyond our control. Insurance for goods in transit is
                                the responsibility of the client unless explicitly agreed otherwise.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Use of Website</h3>
                            <p>
                                By using our website, you agree not to misuse it in any way. All content including
                                images, logos, text, and service details is the intellectual property of Khandelwal
                                Roadlines and may not be used or reproduced without prior written consent.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Governing Law</h3>
                            <p>
                                These terms shall be governed by and construed in accordance with the laws of India. Any
                                disputes arising out of or related to our services shall be subject to the jurisdiction
                                of courts located in Indore, Madhya Pradesh.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Contact Us</h3>
                            <p>
                                If you have any questions or concerns regarding these terms, feel free to contact us at:
                                <br>
                                <strong>Khandelwal Roadlines</strong><br>
                                Address: Khandelwal Chembers, 13, Ujjain Road, Abhinav Hotel, Opposite Abhinav Talkies,
                                Shivaji Nagar, Itawa Dewas - 455001 (Madhya Pradesh) India <br>
                                Phone: +91 7272408628 <br>
                                Email: info@khandelwalroadlines.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- terms of service end -->
         
        @endsection