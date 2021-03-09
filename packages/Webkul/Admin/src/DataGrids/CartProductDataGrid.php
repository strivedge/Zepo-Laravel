<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;

class CartProductDataGrid extends DataGrid
{
    protected $sortOrder = 'desc';

    protected $index = 'product_id';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cart')
            ->leftJoin('cart_items', 
                'cart_items.cart_id', '=', 'cart.id')
            ->addSelect(
                'cart.id as id', 
                'cart.customer_email', 
                'cart.customer_first_name', 
                'cart.customer_last_name', 
                'cart.items_count', 
                'cart.items_qty', 
                'cart.grand_total')
            ->addSelect(
                'cart_items.id as cart_item_id', 
                'cart_items.sku as sku', 
                'cart_items.type', 
                'cart_items.name as product_name', 
                'cart_items.base_price', 
                'cart_items.total', 
                'cart_items.updated_at');

        $this->addFilter('id', 'id');
        $this->addFilter('name', 'cart.customer_first_name');
        $this->addFilter('grand_total', 'cart.grand_total');
        $this->addFilter('product_name', 'product_name');

        // echo "<pre>"; print_r($this->queryBuilder); exit();
        $this->setQueryBuilder($queryBuilder);
    }
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'sku',
            'label'      => trans('admin::app.datagrid.sku'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    // public function prepareActions()
    // {
    //     $this->addAction([
    //         'title'     => trans('admin::app.datagrid.edit'),
    //         'method'    => 'GET',
    //         'route'     => 'admin.catalog.products.edit',
    //         'icon'      => 'icon pencil-lg-icon',
    //         'condition' => function () {
    //             return true;
    //         },
    //     ]);

    //     $this->addAction([
    //         'title'        => trans('admin::app.datagrid.delete'),
    //         'method'       => 'POST',
    //         'route'        => 'admin.catalog.products.delete',
    //         'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
    //         'icon'         => 'icon trash-icon',
    //     ]);
    // }

    // public function prepareMassActions()
    // {
    //     $this->addAction([
    //         'title'  => trans('admin::app.datagrid.copy'),
    //         'method' => 'GET',
    //         'route'  => 'admin.catalog.products.copy',
    //         'icon'   => 'icon copy-icon',
    //     ]);

    //     $this->addMassAction([
    //         'type'   => 'delete',
    //         'label'  => trans('admin::app.datagrid.delete'),
    //         'action' => route('admin.catalog.products.massdelete'),
    //         'method' => 'DELETE',
    //     ]);

    //     $this->addMassAction([
    //         'type'    => 'update',
    //         'label'   => trans('admin::app.datagrid.update-status'),
    //         'action'  => route('admin.catalog.products.massupdate'),
    //         'method'  => 'PUT',
    //         'options' => [
    //             'Active'   => 1,
    //             'Inactive' => 0,
    //         ],
    //     ]);
    // }
}