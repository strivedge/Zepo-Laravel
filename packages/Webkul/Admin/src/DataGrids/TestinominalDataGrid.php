<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class TestinominalDataGrid extends DataGrid
{
    protected $index = 'testinominal_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_testinominal')
        ->addSelect('id as testinominal_id', 'title', 'image', 'desc', 'date');
        $this->addFilter('testinominal_id', 'id');
        $this->addFilter('title', 'title');
        $this->addFilter('date', 'date');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'testinominal_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'image',
        //     'label'      => trans('admin::app.customers.testinominalds.testinominals-image'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => false,
        //     'filterable' => false,
        // ]);

        $this->addColumn([
            'index'      => 'desc',
            'label'      => trans('admin::app.customers.testinominals.testinominals-desc'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'date',
            'label'      => trans('admin::app.customers.testinominals.testinominals-date'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'method' => 'GET',
            'route'  => 'testinominal_edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.testinominals.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'testinominal_delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.customers.testinominals.delete-help-title'),
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
            'action' => route('testinominal_masssdelete'),
            'method' => 'PUT',
        ]);
    }
}