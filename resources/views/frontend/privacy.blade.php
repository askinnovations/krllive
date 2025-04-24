 
 @extends('frontend.layouts.app')
@section('title') {{ 'privacy' }} @endsection
@section('content')

 <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background-image: url('{{ asset('frontend/img/breadcrumb/01.jpg') }}')">
            <div class="container">
                <h2 class="breadcrumb-title">Privacy Policy</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="active">Privacy Policy</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- privacy policy -->
        <div class="privacy-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="terms-content">
                            <h3>Privacy Policy</h3>
                            <p>
                                At Khandelwal Roadlines, we are committed to protecting your privacy. This policy
                                outlines how we collect, use, and safeguard your information when you interact with our
                                website or services. By using our website, you consent to the practices described in
                                this policy.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Information We Collect</h3>
                            <p>
                                We may collect personal information such as your name, contact number, email address,
                                company details, and location when you fill out forms or contact us. We also gather
                                non-personal data like browser type, IP address, and pages visited to enhance user
                                experience.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>How We Use Information</h3>
                            <p>
                                The collected information is used to:
                                <br>
                                - Respond to your inquiries and provide services<br>
                                - Improve our website and offerings<br>
                                - Send updates or promotional content (only with your consent)<br>
                                - Ensure compliance with legal obligations
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Data Security</h3>
                            <p>
                                We implement strict security measures to protect your data from unauthorized access or
                                disclosure. While we strive to use commercially acceptable means to safeguard your
                                information, we cannot guarantee absolute security.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Third-Party Sharing</h3>
                            <p>
                                We do not sell, trade, or transfer your personally identifiable information to outside
                                parties except when necessary to deliver our services or comply with the law.
                            </p>
                        </div>
                        <div class="terms-content">
                            <h3>Changes to This Policy</h3>
                            <p>
                                Khandelwal Roadlines reserves the right to modify this privacy policy at any time. Any
                                changes will be posted on this page, and your continued use of the site constitutes your
                                acceptance of those changes.
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
        <!-- privacy policy end -->

        @endsection