<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class CustomerPriceDataGrid extends DataGrid
{
    protected $index = 'product_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('customer_product_price')
        ->leftJoin('product_flat', 'product_flat.product_id','=','customer_product_price.product_id')
        ->addSelect('product_flat.name as product_name','customer_product_price.id as product_price_id', 'customer_product_price.product_id', 'customer_product_price.customer_id', 'customer_product_price.price', 'customer_product_price.updated_at')->groupBy('customer_product_price.product_id');
        $this->addFilter('product_name', 'product_name');
        $this->addFilter('customer_id', 'customer_id');
        $this->addFilter('updated_at', 'updated_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.catalog.customer.product'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'product_id',
        //     'label'      => trans('admin::app.catalog.customer.product'),
        //     'type'       => 'string',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => true,
        // ]);

        // $this->addColumn([
        //     'index'      => 'customer_id',
        //     'label'      => trans('admin::app.catalog.customer.customer'),
        //     'type'       => 'number',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => true,
        // ]);

       
        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('admin::app.catalog.customer.updated-at'),
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
            'route'  => 'admin.catalog.customer.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.catalog.customer.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.catalog.customer.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.catalog.customer.delete-help-title'),
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
            'action' => route('admin.catalog.customer.massdelete'),
            'method' => 'PUT',
        ]);

    }
}