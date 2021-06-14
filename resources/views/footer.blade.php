<footer class="container-fluid fbg-grey py-5 footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="logo-part">
                            <img src="/img/name-logo.png" class="logo-footer">
                            <p>Our LAK MARKET provide next level of online<br> shopping experience to our valueable <br>customer.</p>
                        </div>
                    </div>
                    <div class="col-md-6 px-4">
                        <h6> About LAK MARKET</h6>
                        <p>For more details about our LAK MARKET, </p>
                        <a href="{{route('about')}}" class="btn-footer">About</a>
                        <a href="{{route('customer-care')}}" class="btn-footer"> Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5 px-4">
                        <h6> Connect With Us</h6>
                        <div class="social">
                            <a href="#"><i class="fab fa-facebook-square fa-2x" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-instagram  fa-2x" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-youtube  fa-2x" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-7 ">
                        <h6>Get Newsletters</h6>

                        <form action="{{route('add.newsletter')}}" method="POST" class="my-3 footer-form-newsletter">
                            @csrf
                            <input type="email" placeholder="Enter your email" name="email" class="footer-form-input" required>
                            <button class="footer-form-submit">Subscribe</button>
                        </form>
                        <p>Subscribe for get newsletter alerts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>