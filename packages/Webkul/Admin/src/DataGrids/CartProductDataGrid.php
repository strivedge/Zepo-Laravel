<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;

class CartProductDataGrid extends DataGrid
{
    protected $sortOrder = 'desc';

    protected $index = 'id';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cart')
            ->leftJoin('cart_items', 
                'cart_items.cart_id', '=', 'cart.id')
            ->leftJoin('customers', 
                'customers.id', '=', 'cart.customer_id')
            ->addSelect(
                'cart.id as id', 
                'cart.customer_email as customer_email', 
                DB::raw("CONCAT(cart.customer_first_name,' ',cart.customer_last_name) as full_name"),
                'cart.items_count as items_count', 
                'cart.items_qty as items_qty',
                'cart.base_grand_total as base_grand_total', 
                'cart.grand_total as grand_total',
                'cart.status as status',)
            ->addSelect(
                'cart_items.id as cart_item_id', 
                'cart_items.sku as sku', 
                'cart_items.type as type', 
                'cart_items.name as product_name', 
                'cart_items.quantity as quantity', 
                'cart_items.price as price', 
                'cart_items.base_price as base_price', 
                'cart_items.total as total', 
                'cart_items.base_total as base_total', 
                'cart_items.updated_at as updated_at')
            ->addSelect(
                'customers.phone as phone')
            ->where('cart.customer_email', '!=', null);

        $this->addFilter('id', 'id');
        $this->addFilter('sku', 'sku');
        // $this->addFilter('grand_total', 'cart.grand_total');
        $this->addFilter('product_name', 'cart_items.name');
        $this->addFilter('quantity', 'cart_items.quantity');
        $this->addFilter('price', 'cart_items.price');
        $this->addFilter('total', 'cart_items.total');
        $this->addFilter('status', 'cart.status');
        $this->addFilter('updated_at', 'cart_items.updated_at');

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
            'index'      => 'full_name',
            'label'      => trans('admin::app.sales.cart-products.full-name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'customer_email',
            'label'      => trans('admin::app.sales.cart-products.email'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => trans('admin::app.sales.cart-products.phone'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->phone == '') {
                    return '<center>-</center>';
                }
                else {
                    return $row->phone;
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.sales.cart-products.product-name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        // $this->addColumn([
        //     'index'      => 'items_qty',
        //     'label'      => trans('admin::app.sales.cart-products.items-qty'),
        //     'type'       => 'double',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => true,
        // ]);

        // $this->addColumn([
        //     'index'      => 'items_count',
        //     'label'      => trans('admin::app.sales.cart-products.items-count'),
        //     'type'       => 'number',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'quantity',
            'label'      => trans('admin::app.sales.cart-products.quantity'),
            'type'       => 'number',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => trans('admin::app.sales.cart-products.price'),
            'type'       => 'price',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'base_price',
        //     'label'      => trans('admin::app.sales.cart-products.base-price'),
        //     'type'       => 'price',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'total',
            'label'      => trans('admin::app.sales.cart-products.total'),
            'type'       => 'price',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'grand_total',
        //     'label'      => trans('admin::app.sales.cart-products.grand-total'),
        //     'type'       => 'price',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.sales.cart-products.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-warning">'. trans('admin::app.sales.cart-products.call') .'</span>';
                } if($row->status == 2) {
                    return '<span class="badge badge-md badge-inform">'. trans('admin::app.sales.cart-products.done') .'</span>';
                } if($row->status == 3) {
                    return '<span class="badge badge-md badge-success">'. trans('admin::app.sales.cart-products.completed') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('admin::app.sales.cart-products.pending') .'</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('admin::app.sales.cart-products.updated-at'),
            'type'       => 'datetime',
            'searchable' => false,
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
    // }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.sales.cart-products.update-status'),
            'action'  => route('admin.catalog.cart-products.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Pending'   => 0,
                'Call' => 1,
                'Done' => 2,
                'Completed' => 3,
            ],
        ]);
    }
}