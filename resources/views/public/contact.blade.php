@extends('layouts.pub2')

@section('styles')
    <link rel="stylesheet" href="/pub2/css/contact.css">
    <style type="text/css">
        body {
            overflow-x: hidden;
        }
    </style>
@endsection

@section('content')

    <!--====================================================
                       HOME-P
======================================================-->
    <div id="home-p" class="home-p pages-head1 text-center">
        <div class="container">
            <h1 class="wow fadeInUp" data-wow-delay="0.1s">Contact Us</h1>
        </div><!--/end container-->
    </div>

    <!--====================================================
                            CONTACT-P1
    ======================================================-->
    <section id="contact-p1" class="contact-p1">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <section class="what-we-do bg-gradiant">
                        <div class="container-fluid">
                            <h3>Contact us, we'll be at your service!</h3>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <div class="contact-p1-cont2">
                        <address class="address-details-f">
                            Address: 2nd floor, City Hall, Baguio City<br>
                            Contact No. : (074) 446-3366<br>
                            Workdays: Monday-Friday (8:00am - 5:00pm)<br>
                            Email: <a href="mailto:sanggunianrd@gmail.com">sanggunianrd@gmail.com</a><br>
                            <a href="https://www.facebook.com/researchbaguio" target="_blank"><i class="fa fa-facebook"> acebook </i></a>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--====================================================
                            CONTACT-P2
    ======================================================-->
    <service class="contact-p2" id="contact-p2">
        <div class="container">

            @if(Session('flash_message'))

                <p class="alert alert-success">{{ Session('flash_message') }}</p>

            @endif

            <form id="contact" action="/contact" method="post" role="form" class="form contactForm">
                {{ csrf_field() }}

                <div class="row con-form">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" id="name"
                               placeholder="Your Name" data-rule="minlen:4"
                               data-msg="Please enter at least 4 chars" required/>
                        <div class="validation"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Your Email" data-rule="email"
                                   data-msg="Please enter a valid email" required/>
                            <div class="validation"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input required type="text" class="form-control" name="subject" id="subject"
                                   placeholder="Subject" data-rule="minlen:4"
                                   data-msg="Please enter at least 8 chars of subject"/>
                            <div class="validation"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                                                <textarea id="message" class="form-control" name="message" rows="5"
                                                          data-rule="required" data-msg="Please write something for us"
                                                          placeholder="Message" required></textarea>
                            <div class="validation"></div>
                        </div>
                    </div>
                    <div class="submit col-md-12 sub-but text-center">
                        <button id="send" class="btn btn-general btn-white" type="submit" value="submit">
                            Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </service>

    <!--====================================================
                       MAP
======================================================-->
    <section id="contact-add">
        <div id="map">
            <div class="map-responsive">
                {{--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d6030.418742494061!2d-111.34563870463673!3d26.01036670629853!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2smx!4v1471908546569"--}}
                {{--width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5412.508393482443!2d120.58967725508535!3d16.413578918578363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a1660714d85b%3A0xfc1420eb5a454b71!2sCity+Planning+%26+Dev&#39;t+Officer!5e0!3m2!1sen!2sph!4v1525562208424"
                        width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        function validateForm(x) {
            var name = document.forms["contact"]["name"].value;
            var email = document.forms["contact"]["email"].value;
            var subject = document.forms["contact"]["subject"].value;
            var message = document.forms["contact"]["message"].value;
            if (name == "" || email == "" || subject == "" || message == "") {

            } else
                document.getElementById('contact').submit();
        }

        $('#flash').delay(500).fadeIn(250).delay(5000).fadeOut(500);
    </script>
@endsection