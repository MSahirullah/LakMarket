@extends('layouts.app')

@section('css')
<link href="{{ URL::asset('/css/about.css') }}" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap" rel="stylesheet">

@endsection

@section('content')

<div class="site-wrapper pt-16 ">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="#">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">About</a>
    </div>
    <div class="site-container container bg-w pt-20">
        <div class="about-logo">
            <div class="uni-logo"></div>
            <div class="lakmarket-logo"></div>
        </div>
        <div class="about-us">

            <div class="about-text-1">
                Our awesome team gives a big chance to make shopping activities very easy. <br><b>This is the time to bring your nearest and favourite shop into your place.</b>
            </div>
            <hr>
            <div class="about-title">
                Our Mission
            </div>
            <div class="about-text-1">
                <b>Connect the nearest store to your live location and provide a fastest <br> 24 hour service.</br></b>
            </div>
            <hr>
            <div class="about-title">
                Our Team
            </div>
            <div class="about-text-2">
                <div class="team-details row jc-c">
                    <div class="member col">
                        <div class="photo" style="background-image:url('/img/seller-temp.png')">
                        </div>
                        <div class="name">
                            A.B Cdefg Highjkl
                        </div>
                        <div class="about-social">
                            <a href="#"><i class="fab fa-facebook-square"></i></a>
                            <a href="#"><i class="fab fa-instagram-square"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github-square mr-0"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-details row jc-c">
                    <div class="member col">
                        <div class="photo" style="background-image:url('/img/seller-temp.png')">
                        </div>
                        <div class="name">
                            A.B Cdefg Highjkl
                        </div>
                        <div class="about-social">
                            <a href="#"><i class="fab fa-facebook-square"></i></a>
                            <a href="#"><i class="fab fa-instagram-square"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github-square mr-0"></i></a>
                        </div>
                    </div>
                    <div class="member col">
                        <div class="photo" style="background-image:url('/img/seller-temp.png')">
                        </div>
                        <div class="name">
                            A.B Cdefg Highjkl
                        </div>
                        <div class="about-social">
                            <a href="#"><i class="fab fa-facebook-square"></i></a>
                            <a href="#"><i class="fab fa-instagram-square"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github-square mr-0"></i></a>
                        </div>
                    </div>
                    <div class="member col">
                        <div class="photo" style="background-image:url('/img/seller-temp.png')">
                        </div>
                        <div class="name">
                            A.B Cdefg Highjkl
                        </div>
                        <div class="about-social">
                            <a href="#"><i class="fab fa-facebook-square"></i></a>
                            <a href="#"><i class="fab fa-instagram-square"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github-square mr-0"></i></a>
                        </div>
                    </div>
                </div>
                We are talented team in the University of Colombo from Faculty of Technology, <br> ICT Department. We have been following Information Communication Technology degree programs since 2019.
            </div>
            <hr>
        </div>
    </div>
</div>

@endsection