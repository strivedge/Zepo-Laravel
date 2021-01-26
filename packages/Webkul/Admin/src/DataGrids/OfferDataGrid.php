<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class OfferDataGrid extends DataGrid
{
    protected $index = 'offer_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_offers')
        ->addSelect('id as offer_id', 'title', 'desc', 'image', 'start_date', 'end_date', 'status');
        $this->addFilter('offer_id', 'id');
        $this->addFilter('title', 'title');
        $this->addFilter('desc', 'desc');
        $this->addFilter('start_date', 'start_date');
        $this->addFilter('end_date', 'end_date');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'offer_id',
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

        $this->addColumn([
            'index'      => 'desc',
            'label'      => trans('admin::app.customers.offers.offer-desc'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        // $this->addColumn([
        //     'index'      => 'image',
        //     'label'      => trans('admin::app.customers.offers.offer-image'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => false,
        //     'filterable' => false,
        // ]);

        $this->addColumn([
            'index'      => 'start_date',
            'label'      => trans('admin::app.customers.offers.start-date'),
            'type'       => 'date',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => true,
        ]);

        $this->addColumn([
            'index'      => 'end_date',
            'label'      => trans('admin::app.customers.offers.end-date'),
            'type'       => 'date',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.customers.offers.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('admin::app.customers.offers.active') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('admin::app.customers.offers.inactive') .'</span>';
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'method' => 'GET',
            'route'  => 'offer_edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.offers.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'offer_delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.customers.offers.delete-help-title'),
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
            'action' => route('offer_masssdelete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('offer_masssupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}