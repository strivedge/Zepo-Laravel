<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class OfferGallaryDataGrid extends DataGrid
{
    protected $index = 'offerGallary_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_offer_gallary')
        ->addSelect('id as offerGallary_id', 'title', 'image', 'status', 'updated_at');
        $this->addFilter('offerGallary_id', 'id');
        $this->addFilter('title', 'title');
        $this->addFilter('status', 'status');
        $this->addFilter('updated_at', 'updated_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'offerGallary_id',
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
            'index'      => 'status',
            'label'      => trans('admin::app.settings.offer-gallary.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('admin::app.settings.offer-gallary.active') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('admin::app.settings.offer-gallary.inactive') .'</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('admin::app.settings.offer-gallary.updated-at'),
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
            'route'  => 'admin.offer-gallary.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.settings.offer-gallary.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.offer-gallary.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.settings.offer-gallary.delete-help-title'),
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
            'action' => route('admin.offer-gallary.massdelete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.offer-gallary.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}