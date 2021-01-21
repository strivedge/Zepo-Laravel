<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Product\Repositories\SearchRepository;
use DB;

class HomeController extends Controller
{
    /**
     * SliderRepository object
     *
     * @var \Webkul\Core\Repositories\SliderRepository
    */
    protected $sliderRepository;

    /**
     * SearchRepository object
     *
     * @var \Webkul\Core\Repositories\SearchRepository
    */
    protected $searchRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @param  \Webkul\Product\Repositories\SearchRepository  $searchRepository
     * @return void
    */
    public function __construct(
        SliderRepository $sliderRepository,
        SearchRepository $searchRepository
    )
    {
        $this->sliderRepository = $sliderRepository;

        $this->searchRepository = $searchRepository;

        parent::__construct();
    }

    /**
     * loads the home page for the storefront
     * 
     * @return \Illuminate\View\View 
     */
    public function index()
    {
        $currentChannel = core()->getCurrentChannel();

        $currentLocale = core()->getCurrentLocale();

        // fetched data for blogs (posts) and offers
        $offers_title = "Active Offers";
        $offers = DB::table('master_offers')->orderby('id','desc')->take(1)->get();
        $posts_title = "Posts";
        $posts = DB::table('master_posts')->orderby('id','desc')->get();

        // testinominal title and fetched data for testinominals
        $testi_title = "What Our Customers are Saying";
        $testinominals = DB::table('master_testinominal')->orderby('id','desc')->get();

        $sliderData = $this->sliderRepository
            ->where('channel_id', $currentChannel->id)
            ->where('locale', $currentLocale->code)
            ->get()
            ->toArray();

        return view($this->_config['view'], compact('sliderData', 'offers_title', 'offers', 'posts_title', 'posts', 'testi_title', 'testinominals'));
    }

    /**
     * loads the home page for the storefront
     * 
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }

    /**
     * Upload image for product search with machine learning
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $url = $this->searchRepository->uploadSearchImage(request()->all());

        return $url; 
    }
}