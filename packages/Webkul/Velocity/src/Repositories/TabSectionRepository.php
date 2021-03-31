<?php

namespace Webkul\Velocity\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Webkul\Velocity\Models\TabSection;

class TabSectionRepository extends Repository
{
    function model()
    {
        return 'Webkul\Velocity\Models\TabSection';
    }

    // Admin side
    public function getAll()
    {
    	return $this->model->first();
    }

    public function modify($datas)
    {
        // echo "<pre>"; print_r($datas); exit();
    	if($this->getAll() != null) {
    		$categories = $this->model->where('id', 1)->update(['category_id' => $datas]);
    	} else {
    		$categories = $this->model->create(['category_id' => $datas]);
    	}
    	
    	return $categories;
    }

    // front-end homepage
    public function getCategories()
    {
        $categories = DB::table('master_tabsection')->first();
        if(isset($categories->category_id) != null) {
            $getCategory = explode(",", $categories->category_id);
        } else {
            $getCategory = [];
        }


        $tabbing = DB::table('categories')->distinct()
        ->addSelect('categories.id', 'categories.position', 'categories.status')
        ->addSelect('category_translations.category_id as category_id', 'category_translations.name as category_name', 'category_translations.url_path as category_url_path', 'category_translations.locale')
        ->leftJoin('category_translations', function ($join) {
            $join->on('category_translations.category_id', '=' , 'categories.id');
            $join->where('category_translations.locale', '=' , 'en');
            $join->where('category_translations.category_id', '!=' , 1);
        })
        ->whereIn('category_translations.category_id', $getCategory)
        ->orderBy('id', 'desc')
        ->take(3)->get();

        return $tabbing;
    }
}