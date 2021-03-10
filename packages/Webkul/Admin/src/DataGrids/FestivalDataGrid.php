<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class FestivalDataGrid extends DataGrid
{
    protected $index = 'festival_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_festival')
        ->addSelect('id as festival_id', 'title', 'short_desc','long_desc', 'image', 'start_date', 'end_date', 'status');
        $this->addFilter('festival_id', 'id');
        $this->addFilter('title', 'title');
        $this->addFilter('short_desc', 'short_desc');

        $this->addFilter('start_date', 'start_date');
        $this->addFilter('end_date', 'end_date');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'festival_id',
            'label'      => trans('festival::app.festival.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('festival::app.festival.title'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'short_desc',
            'label'      => trans('festival::app.festival.short_desc'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'long_desc',
            'label'      => trans('festival::app.festival.long_desc'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        // $this->addColumn([
        //     'index'      => 'image',
        //     'label'      => trans('festival::app.festival.festival-image'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => false,
        //     'filterable' => false,
        // ]);

        $this->addColumn([
            'index'      => 'start_date',
            'label'      => trans('festival::app.festival.start-date'),
            'type'       => 'datetime',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'end_date',
            'label'      => trans('festival::app.festival.end-date'),
            'type'       => 'datetime',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('festival::app.festival.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('festival::app.festival.active') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('festival::app.festival.inactive') .'</span>';
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'method' => 'GET',
            'route'  => 'admin.festival.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('festival::app.festival.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.festival.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('festival::app.festival.delete-help-title'),
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
            'action' => route('admin.festival.massdelete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.festival.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}