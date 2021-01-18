<!-- <header class="sticky-header" v-if="!isMobile()">
    <div class="row col-12 remove-padding-margin velocity-divide-page">
        <logo-component></logo-component>
        <searchbar-component></searchbar-component>
    </div>
</header> -->

<nav class="navbar fixed-top" id="navbar">
                <div class="navbar-top">
                    <div class="container">
                        <div class="navbar-top-wrapper">
                            <div class="navbar-left-wrapper col-md-6">
                                <ul>
                                    <li class="email"><a href="mailto:support@zepomart.com">support@zepomart.com</a></li>
                                    <li class="phone"><a href="tel:021 269 962">021 269 962 </a></li>
                                </ul>
                            </div>
                            <div class="navbar-right-wrapper col-md-6">
                                <ul>
                                    <li><a href="#">Create Ticket</a></li>
                                    <li><a href="#">Login</a></li>
                                    <li><a href="#">Register</a></li>
                                    <li class="country-dollars">
                                        <select class="selectpicker" data-width="fit">
                                            <option data-content='US Dollars ($)'>US Dollars ($)</option>
                                            <option  data-content='US Dollars ($)'>US Dollars ($)</option>
                                        </select>
                                    </li>
                                    <li class="country-dollars">
                                        <select class="selectpicker" data-width="fit">
                                            <option data-content='<span class="flag-icon"><img src="images/united-states.svg"></span> English'>English</option>
                                            <option  data-content='<span class="flag-icon"><img src="images/united-states.svg"></span> English'>English</option>
                                        </select>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navbar-middle">
                    <div class="container">
                        <div class="navbar-middle-wrapper">
                            <a class="navbar-brand col-md-2" href="#"><img src="images/logo.png" class="custom-logo" alt="" itemprop="logo"></a>
                             <div class="navbar--search col-md-7">
                                    <form>
                                        <div class="form-group">
                                            <input type="text" name="search" class="" placeholder="Search Products">
                                            <button class="search-btn"><i class='bx bx-search'></i></button>
                                        </div>
                                    </form>
                            </div>
                            <div class="navbar--addcart--wishlist col-md-3">
                                <a href="#">
                                    <span class="wishlist"><i class='bx bx-heart'></i></span>
                                </a>
                                <a href="#">
                                    <span class="addcart"><i class='bx bx-cart-alt' ></i><span class="badge badge-secondary">56</span></span>
                                </div>
                                </a>
                        </div>
                    </div>
                </div>
               <div class="navbar-bottom">
                <div class="container">
                    <div class="wrapper-menu">
                        <div class="line-menu start"></div>
                        <div class="line-menu"></div>
                        <div class="line-menu half end"></div>
                    </div>
                    <ul class="navbar-nav" id="primary-menu">
                        <li class="nav-item"> <a class="nav-link" href="#">Shop By Categories</a> </li>
                        <li class="nav-item parent">
                            <a class="nav-link" href="#">Brand</a>
                            <ul class="sub-menu">
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                                <li><a href="#">Brand</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="events-list.html"> Covid19 Products</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#">Store Directory</a></li>
                        <li class="nav-item"> <a class="nav-link" href="#">About Us</a></li>
                        <li class="nav-item"> <a class="nav-link" href="case-studies.html"> Contact Us</a></li>
                    </ul>
                </div>    
                    
                </div> 
            </nav>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 50){
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })()
    </script>
@endpush
