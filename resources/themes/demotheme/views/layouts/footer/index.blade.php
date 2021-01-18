<!-- <div class="footer">
    <div class="footer-content">

        @include('shop::layouts.footer.newsletter-subscription')
        @include('shop::layouts.footer.footer-links')

        {{-- @if ($categories)
            @include('shop::layouts.footer.top-brands')
        @endif --}}

        @if (core()->getConfigData('general.content.footer.footer_toggle'))
            @include('shop::layouts.footer.copy-right')
        @endif
    </div>
</div> -->

<footer class="footer">
                    <div class="footer-top">
                        <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3 footer-block">
                                <div class="footer-block-title">Quick Links</div>
                                <div class="footer-block-content">
                                    <ul>
                                        <li><a href="#">Home</a> </li>
                                        <li><a  href="#">Self Definition</a></li>
                                        <li><a href="#">Procedure</a> </li>
                                        <li><a  href="#">Self Definition</a></li>
                                        <li><a href="#">Our Valued Customers</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 footer-block">
                                <div class="footer-block-title">Help</div>
                                <div class="footer-block-content">
                                    <ul>
                                        <li><a href="#">Payments</a> </li>
                                        <li><a  href="#">Shipping</a></li>
                                        <li><a href="#">Cancellation & Returns</a> </li>
                                        <li><a  href="#">FAQ</a></li>
                                        <li><a href="#">Mesurement Process</a></li>
                                    </ul>                             
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-2 footer-block">
                                <div class="footer-block-column">
                                    <div class="col-left">
                                        <div class="footer-block-title">Contact Us</div>
                                        <div class="footer-block-content">
                                            <ul>
                                                <li><a href="#">About Us</a> </li>
                                                <li><a  href="#">Contact</a></li>
                                                <li><a href="#">Work with Us</a> </li>
                                                <li><a  href="#">Privacy Policy</a></li>
                                                <li><a href="#">Terms & Conditions</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 footer-block">
                                <div class="footer-block-content">
                                    <div class="col-right">
                                        <div class="footer-block-title">Newsletter</div>
                                        <div class="footer-block-content">
                                            <div class="newsletter-content">
                                                <p>Our email subscribers get the inside scoop on new products, Promotions, Contests and more. Sign up, it's right thing to do.</p>
                                            </div>
                                            <form>
                                                <!-- <label for="email">Subscribe</label> -->
                                                <input type="text" name="email" placeholder="Enter Your Email" class="email">
                                                <button type="submit" class="btn btn-primary email-button"><i class='bx bxs-paper-plane'></i> Submit</button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="footer-middle">
                        <div class="container">
                            <div class="footer-middle-content">
                                    <div class="partner-logo col-md-6">
                                        <ul>
                                            <li><img src="images/pay.png"></li>
                                            <li><img src="images/discover.png"></li>
                                            <li><img src="images/american-express.png"></li>
                                            <li><img src="images/visa.png"></li>
                                            <li><img src="images/mastercard.png"></li>
                                            <li><img src="images/pay.png"></li>
                                        </ul>
                                    </div>
                                    <div class="social-links col-md-6">
                                        <ul>
                                            <li><a href="#"><span><i class='bx bxl-facebook' ></i></span></a></li>
                                            <li><a href="#"><span><i class='bx bxl-twitter' ></i></span></a></li>
                                            <li><a href="#"><span><i class='bx bxl-linkedin' ></i></span></a></li>
                                            <li><a href="#"><span><i class='bx bxl-instagram' ></i></span></a></li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom">
                            <div class="container">
                                 <p class="copyrights">Copyright © 2021 Zepomart. All Rights Reserved.</p>
                            </div>
                    </div>
            </footer>


