<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class DiscountDataGrid extends DataGrid
{
    protected $index = 'discount_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_product_discount')
        ->addSelect('id as discount_id', 'discount_type', 'percentage', 'discount_condition', 'discount_qty', 'discount_purchase', 'discount_by', 'status', 'updated_at');
        $this->addFilter('discount_id', 'id');
        $this->addFilter('discount_type', 'discount_type');
        $this->addFilter('percentage', 'percentage');
        $this->addFilter('discount_qty', 'discount_qty');
        $this->addFilter('discount_purchase', 'discount_purchase');
        $this->addFilter('discount_by', 'discount_by');
        $this->addFilter('status', 'status');
        $this->addFilter('updated_at', 'updated_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'discount_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'discount_type',
            'label'      => trans('admin::app.catalog.discounts.discount-type'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'percentage',
            'label'      => trans('admin::app.catalog.discounts.percentage'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'discount_condition',
            'label'      => trans('admin::app.catalog.discounts.condition'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'discount_qty',
            'label'      => trans('admin::app.catalog.discounts.qty'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->discount_qty != null) {
                    return $row->discount_qty;
                } else {
                    return '-';
                }
            }
        ]);

        $this->addColumn([
            'index'      => 'discount_purchase',
            'label'      => trans('admin::app.catalog.discounts.purchase'),
            'type'       => 'price',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->discount_purchase != null) {
                    return $row->discount_purchase;
                } else {
                    return '-';
                }
            }
        ]);

        $this->addColumn([
            'index'      => 'discount_by',
            'label'      => trans('admin::app.catalog.discounts.discount-by'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.catalog.discounts.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('admin::app.catalog.discounts.active') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('admin::app.catalog.discounts.inactive') .'</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('admin::app.catalog.discounts.updated-at'),
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
            'route'  => 'admin.catalog.discount.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.catalog.discounts.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.catalog.discount.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.catalog.discounts.delete-help-title'),
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
            'action' => route('admin.catalog.discount.massdelete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.catalog.discount.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}