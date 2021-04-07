<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class ZipCodeDataGrid extends DataGrid
{
    protected $index = 'zipcode_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_zip_codes')
        ->addSelect('id as zipcode_id', 'area_name', 'zipcode', 'status', 'updated_at');
        $this->addFilter('zipcode_id', 'id');
        $this->addFilter('area_name', 'area_name');
        $this->addFilter('zipcode', 'zipcode');
        $this->addFilter('status', 'status');
        $this->addFilter('updated_at', 'updated_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'zipcode_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'area_name',
            'label'      => trans('admin::app.catalog.zipcodes.area-name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'zipcode',
            'label'      => trans('admin::app.catalog.zipcodes.zipcode'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.catalog.zipcodes.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('admin::app.catalog.zipcodes.active') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('admin::app.catalog.zipcodes.inactive') .'</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('admin::app.catalog.zipcodes.updated-at'),
            'type'       => 'datetime',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'method' => 'GET',
            'route'  => 'admin.catalog.zipcode.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.catalog.zipcodes.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.catalog.zipcode.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.catalog.zipcodes.delete-help-title'),
        ]);
    }

    /**
     * Customer Mass Action To Delete And Change Their
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.catalog.zipcode.massdelete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.catalog.zipcode.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}