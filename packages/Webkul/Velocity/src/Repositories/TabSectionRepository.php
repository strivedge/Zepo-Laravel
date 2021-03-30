<?php

namespace Webkul\Velocity\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\Velocity\Models\TabSection;

class TabSectionRepository extends Repository
{
    function model()
    {
        return 'Webkul\Velocity\Models\TabSection';
    }

    public function getAll()
    {
    	return $this->model->first();
    }

    public function modify($datas)
    {
    	// echo $this->getAll(); exit();
    	if($this->getAll() != null) {
    		$categories = $this->model->where('id', 1)->update(['category_id' => $datas]);
    	} else {
    		$categories = $this->model->create(['category_id' => $datas]);
    	}
    	
    	return $categories;
    }
}