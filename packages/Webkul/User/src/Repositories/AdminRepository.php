<?php

namespace Webkul\User\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\User\Models\Admin;

class AdminRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\User\Contracts\Admin';
    }

    public function allSeller()
    {
    	$sellers = $this->model->where('role_id', 2)->get();

    	return $sellers;
    }
}