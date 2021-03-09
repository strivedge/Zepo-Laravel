<?php

namespace Custom\Offer\Http\Controllers;;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custom\Offer\Models\Offer;
use Custom\Offer\Repositories\OfferRepository;

class OfferHomeController extends Controller
{
    private $offerRepository;
    public function __construct(OfferRepository $offerRepository)
    {
        $this->_config = request('_config');
        $this->offerRepository = $offerRepository;
    }

    public function index()
    {
        return view($this->_config['view']);
    }
}
