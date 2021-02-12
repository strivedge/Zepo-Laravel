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
    	$sellers = $this->model->where('role_id', 2)
        ->select('admins.id as id',
        'admins.name as name',
        'admins.role_id as admin_role_id',
        'roles.name as role_name')
        ->leftJoin('roles', 'roles.id', '=', 'admins.role_id')
        ->get();

    	return $sellers;
    }
}