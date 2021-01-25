<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class BlogDataGrid extends DataGrid
{
    protected $index = 'blog_id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('master_posts')
        ->addSelect('id as blog_id', 'title', 'image', 'content', 'date');
        $this->addFilter('blog_id', 'id');
        $this->addFilter('title', 'title');
        $this->addFilter('date', 'date');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'blog_id',
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
        //     'label'      => trans('admin::app.customers.blogs.blog-image'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => false,
        //     'filterable' => false,
        // ]);

        $this->addColumn([
            'index'      => 'content',
            'label'      => trans('admin::app.customers.blogs.blog-content'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'date',
            'label'      => trans('admin::app.customers.blogs.blog-date'),
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
            'route'  => 'blog_edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.blogs.edit-help-title'),
        ]);


        $this->addAction([
            'method' => 'POST',
            'route'  => 'blog_delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.customers.blogs.delete-help-title'),
        ]);
    }

    /**
     * Customer Mass Action To Delete And Change Their
     */
    // public function prepareMassActions()
    // {
    //     $this->addMassAction([
    //         'type'   => 'delete',
    //         'label'  => trans('admin::app.datagrid.delete'),
    //         'action' => route('admin.customer.mass-delete'),
    //         'method' => 'PUT',
    //     ]);

    //     $this->addMassAction([
    //         'type'    => 'update',
    //         'label'   => trans('admin::app.datagrid.update-status'),
    //         'action'  => route('admin.customer.mass-update'),
    //         'method'  => 'PUT',
    //         'options' => [
    //             'Active'   => 1,
    //             'Inactive' => 0,
    //         ],
    //     ]);
    // }
}