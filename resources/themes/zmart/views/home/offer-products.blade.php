<?php $festival = app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts()->count())
   <section class="featured-products sales">
        <div class="container">
            <div class="salesoffers-addtocart">
                <div class="col-md-12 col-lg-3 salesoffers">
                    <div class="imgs"><img src="{{ asset($festival[0]->image) }}"></div>
                    <div class="salesoffers-content">
                    <p>{{ $festival[0]->title }}<br/>
                        {{ $festival[0]->short_desc }}<br/>
                        {{ $festival[0]->long_desc }}<br/>
                        <a href="#" class="promotion btn btn-primary">{{ __('festival::app.festival.more-about-promotion') }}</a></p>
        @php $end_date = $festival[0]->end_date.' '.'23:59:59'; @endphp
            <div class="timers">
                <div class="jumbotron countdown show" data-Date='{{ $end_date }}'>
                    <div class="running">
                        <timer>
                          <span class="days"></span>:<span class="hours"></span>:<span class="minutes"></span>:<span class="seconds"></span>
                        </timer>
                        <div class="break"></div>
                        <div class="labels">
                          <span>Days</span><span>Hours</span><span>Minutes</span><span>Seconds</span>
                    </div>
                </div>
                <a href="#" class="active-promotion btn btn-primary">
                    {{ __('festival::app.festival.active-promotions') }}<span><i class="bx bx-right-arrow-alt"></i></span>
                </a>
            </div>
                </div>

                <div class="featured-grid product-grid-4 col-md-12 col-lg-9">
                    <ul class="card grid-card product-card-new addtocart">
                    @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts() as $productFlat)
                        @include ('shop::products.offerproduct.offer-product-listing', ['product' => $productFlat])
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>
    try {
      fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
        return true;
      }).catch(function(e) {
        var carbonScript = document.createElement("script");
        carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
        carbonScript.id = "_carbonads_js";
        document.getElementById("carbon-block").appendChild(carbonScript);
      });
    } catch (error) {
      console.log(error);
    }
</script>