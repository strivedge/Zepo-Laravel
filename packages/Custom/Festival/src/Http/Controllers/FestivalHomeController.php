<?php

namespace Custom\Festival\Http\Controllers;

use Illuminate\Http\Request;

class FestivalHomeController extends Controller
{
    public function __construct()
    {
        $this->_config = request('_config');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function morePromotion()
    {
        return view($this->_config['view']);
    }

    public function activePromotion()
    {
        return view($this->_config['view']);
    }
}
