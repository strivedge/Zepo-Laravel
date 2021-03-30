<?php

namespace Webkul\Velocity\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Velocity\Repositories\TabSectionRepository;
use Validator;

class TabSectionController extends Controller
{
	protected $_config;
	protected $categoryRepository;
    protected $tabSectionRepository;

	public function __construct(
        CategoryRepository $categoryRepository,
        TabSectionRepository $tabSectionRepository
    ) 
	{
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->categoryRepository = $categoryRepository;
        $this->tabSectionRepository = $tabSectionRepository;
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function edit()
    {
    	$categories = $this->categoryRepository->getCategoryTree();
        $getChecked = $this->tabSectionRepository->getAll();

        if($getChecked != null) {
            $getcategory = explode(",", $getChecked->category_id);
            $category['category_id'] = $getcategory;
        } else {
            $category['category_id'] = [];
        }

        return view($this->_config['view'], compact('categories', 'category'));
    }

    public function store(Request $request)
    {
        $data = request()->all();
        $datas = implode(",", $data['categories']);
        $categories = $this->tabSectionRepository->modify($datas);
        // echo "<pre>"; print_r($categories); exit();
    	return redirect()->route($this->_config['redirect'], );
    }
}
