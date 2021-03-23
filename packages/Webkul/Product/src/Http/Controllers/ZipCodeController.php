<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Models\ZipCode;
use Webkul\Product\Repositories\ZipCodeRepository;
use Validator;

class ZipCodeController extends Controller
{
    private $zipCodeRepository;
    public function __construct(ZipCodeRepository $zipCodeRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->zipCodeRepository = $zipCodeRepository;
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }
}
