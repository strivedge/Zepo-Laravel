<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class SupportTicketDataGrid extends DataGrid
{
    protected $index = 'ticket_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('support_tickets')
        ->addSelect('id as ticket_id', 'name', 'email', 'message', 'attachment', 'status', 'created_at', 'updated_at');
        $this->addFilter('ticket_id', 'id');
        $this->addFilter('name', 'name');
        $this->addFilter('email', 'email');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'ticket_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('admin::app.datagrid.email'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'message',
        //     'label'      => trans('zepo::app.support-ticket.message'),
        //     'type'       => 'string',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => false,
        // ]);

        // $this->addColumn([
        //     'index'      => 'attachment',
        //     'label'      => trans('zepo::app.support-ticket.attachment'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => false,
        //     'filterable' => false,
        // ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('zepo::app.support-ticket.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('zepo::app.support-ticket.process') .'</span>';
                } else if ($row->status == 2) {
                    return '<span class="badge badge-md badge-success">'. trans('zepo::app.support-ticket.completed') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('zepo::app.support-ticket.pending') .'</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('zepo::app.support-ticket.created-at'),
            'type'       => 'date',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => true,
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('zepo::app.support-ticket.updated-at'),
            'type'       => 'date',
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
            'route'  => 'zepo.support-ticket.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('zepo::app.support-ticket.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'zepo.support-ticket.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('zepo::app.support-ticket.delete-help-title'),
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
            'action' => route('zepo.support-ticket.massdelete'),
            'method' => 'PUT',
        ]);
    }
}