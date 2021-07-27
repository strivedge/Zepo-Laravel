<?php

namespace Webkul\API\Http\Controllers\Shop;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Repositories\ZipCodeRepository;

class ZipCodeController extends Controller
{
	protected $zipCodeRepository;
	public function __construct(ZipCodeRepository $zipCodeRepository)
    {
        $this->_config = request('_config');
        $this->zipCodeRepository = $zipCodeRepository;
    }

	public function get($zipcode)
    {
        $status = 1;
    	$result = $this->zipCodeRepository->checkZip($zipcode, $status);

    	return response()->json([
    			'status' => true,
                'message' => "Success!",
                'data'    => $result,
            ]);
    }
}