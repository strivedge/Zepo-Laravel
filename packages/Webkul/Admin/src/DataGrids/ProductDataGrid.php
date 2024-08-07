<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Core\Models\Locale;
use Webkul\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;

class ProductDataGrid extends DataGrid
{
    protected $sortOrder = 'desc';

    protected $index = 'product_id';

    protected $itemsPerPage = 10;

    protected $locale = 'all';

    protected $channel = 'all';

    /** @var string[] contains the keys for which extra filters to render */
    // protected $extraFilters = [
    //     'channels',
    //     'locales',
    // ];

    public function __construct()
    {
        parent::__construct();

        /* locale */
        $this->locale = request()->get('locale') ?? 'all';

        /* channel */
        $this->channel = request()->get('channel') ?? 'all';

        /* finding channel code */
        if ($this->channel !== 'all') {
            $this->channel = Channel::query()->find($this->channel);
            $this->channel = $this->channel ? $this->channel->code : 'all';
        }
    }

    public function prepareQueryBuilder()
    {
        if ($this->channel === 'all') {
            $whereInChannels = Channel::query()->pluck('code')->toArray();
        } else {
            $whereInChannels = [$this->channel];
        }

        if ($this->locale === 'all') {
            $whereInLocales = Locale::query()->pluck('code')->toArray();
        } else {
            $whereInLocales = [$this->locale];
        }

        /* query builder */
        $queryBuilder = DB::table('product_flat')
            ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
            ->leftJoin('admins', 'admins.id', '=', 'products.seller_id')
            ->leftJoin('roles', 'roles.id', '=', 'admins.role_id')
            ->leftJoin('attribute_families', 'products.attribute_family_id', '=', 'attribute_families.id')
            ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')
            ->select(
                'product_flat.locale',
                'product_flat.channel',
                'product_flat.product_id',
                'products.sku as product_sku',
                'product_flat.name as product_name',
                'products.type as product_type',
                'product_flat.status',
                'product_flat.price',
                'products.seller_id as seller_id',
                'admins.id as admin_id',
                'admins.name as admin_name',
                'roles.id as role_id',
                'roles.name as role_name',
                'attribute_families.name as attribute_family',
                DB::raw('SUM(DISTINCT ' . DB::getTablePrefix() . 'product_inventories.qty) as quantity')
        );

        if(auth()->guard('admin')->user()->role->id != 1)
        {
            $queryBuilder->where('products.seller_id', auth()->guard('admin')->id());
        }

        $queryBuilder->groupBy('product_flat.product_id', 'product_flat.channel');

        $queryBuilder->whereIn('product_flat.locale', $whereInLocales);
        $queryBuilder->whereIn('product_flat.channel', $whereInChannels);
        // $queryBuilder->whereNotNull('product_flat.name');

        $this->addFilter('product_id', 'product_flat.product_id');
        $this->addFilter('product_name', 'product_flat.name');
        $this->addFilter('product_sku', 'products.sku');
        $this->addFilter('status', 'product_flat.status');
        $this->addFilter('product_type', 'products.type');
        $this->addFilter('attribute_family', 'attribute_families.name');

        $this->setQueryBuilder($queryBuilder);
    }
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'product_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_sku',
            'label'      => trans('admin::app.datagrid.sku'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'product_name',
        //     'label'      => trans('admin::app.datagrid.name'),
        //     'type'       => 'string',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'wrapper'    => function ($value) {
                $getId = $value->product_id;
                $getRoute = route('admin.catalog.products.edit', $getId);
                echo "<a href='$getRoute'>$value->product_name</a>";
            },
        ]);

        $this->addColumn([
            'index'      => 'attribute_family',
            'label'      => trans('admin::app.datagrid.attribute-family'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'product_type',
        //     'label'      => trans('admin::app.datagrid.type'),
        //     'type'       => 'string',
        //     'sortable'   => true,
        //     'searchable' => true,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper'    => function ($value) {
                if ($value->status == 1) {
                    return trans('admin::app.datagrid.active');
                } else {
                    return trans('admin::app.datagrid.inactive');
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => trans('admin::app.datagrid.price'),
            'type'       => 'price',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'quantity',
            'label'      => trans('admin::app.datagrid.qty'),
            'type'       => 'number',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => false,
            'wrapper'    => function ($value) {
                if (is_null($value->quantity)) {
                    return 0;
                } else {
                    return $value->quantity;
                }
            },
        ]);
    if(auth()->guard('admin')->user()->role->id == 1)
    {
        $this->addColumn([
            'index'      => 'seller_id',
            'label'      => trans('admin::app.catalog.products.product-by'),
            'type'       => 'number',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => false,
            'wrapper'    => function ($value) {
                if($value->seller_id == null && $value->seller_id == "") {
                    return trans('admin::app.catalog.products.none');
                }
                if ($value->seller_id == $value->admin_id) {
                    return $value->admin_name." (".$value->role_name.")";
                }
            },
        ]);
        }
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'     => trans('admin::app.datagrid.edit'),
            'method'    => 'GET',
            'route'     => 'admin.catalog.products.edit',
            'icon'      => 'icon pencil-lg-icon',
            'condition' => function () {
                return true;
            },
        ]);

        $this->addAction([
            'title'        => trans('admin::app.datagrid.delete'),
            'method'       => 'POST',
            'route'        => 'admin.catalog.products.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon'         => 'icon trash-icon',
        ]);
    }

    public function prepareMassActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.copy'),
            'method' => 'GET',
            'route'  => 'admin.catalog.products.copy',
            'icon'   => 'icon copy-icon',
        ]);

        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.catalog.products.massdelete'),
            'method' => 'DELETE',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.catalog.products.massupdate'),
            'method'  => 'PUT',
            'options' => [
                'Active'   => 1,
                'Inactive' => 0,
            ],
        ]);
    }
}