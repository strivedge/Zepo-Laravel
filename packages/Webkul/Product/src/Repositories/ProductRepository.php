<?php

namespace Webkul\Product\Repositories;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\Product;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;
use Webkul\Attribute\Models\Attribute;
use Webkul\Product\Models\ProductFlat;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Webkul\Product\Models\ProductAttributeValueProxy;
use Webkul\Attribute\Repositories\AttributeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Custom\Festival\Repositories\FestivalRepository;

class ProductRepository extends Repository
{
    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderItemRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderItemRepository
     */
    protected $orderItemRepository;

      protected $festivalRepository;

   

     /**
     * string object
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $startDate;

    /**
     * string object
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $endDate;

    /**
     * Create a new repository instance.
     *
     * @param \Webkul\Attribute\Repositories\AttributeRepository $attributeRepository
     * @param \Illuminate\Container\Container                    $app
     *
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository,
        FestivalRepository $festivalRepository,
        App $app
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->orderRepository = $orderRepository;

        $this->orderItemRepository = $orderItemRepository;

        $this->festivalRepository = $festivalRepository;


        $this->setStartEndDate();

        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'Webkul\Product\Contracts\Product';
    }

    /**
     * @param array $data
     *
     * @return \Webkul\Product\Contracts\Product
     */
    public function create(array $data)
    {
        Event::dispatch('catalog.product.create.before');

        $typeInstance = app(config('product_types.' . $data['type'] . '.class'));

        $product = $typeInstance->create($data);

        Event::dispatch('catalog.product.create.after', $product);

        return $product;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     *
     * @return \Webkul\Product\Contracts\Product
     */
    public function update(array $data, $id, $attribute = "id")
    {
        Event::dispatch('catalog.product.update.before', $id);

        $product = $this->find($id);


        $product = $product->getTypeInstance()->update($data, $id, $attribute);

        if (isset($data['channels'])) {
            $product['channels'] = $data['channels'];
        }

        Event::dispatch('catalog.product.update.after', $product);

        return $product;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete($id)
    {
        Event::dispatch('catalog.product.delete.before', $id);

        parent::delete($id);

        Event::dispatch('catalog.product.delete.after', $id);
    }

    /**
     * @param int $categoryId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll($categoryId = null)
    {
        $params = request()->input();
        $filterInputValues;

        if (core()->getConfigData('catalog.products.storefront.products_per_page')) {
            $pages = explode(',', core()->getConfigData('catalog.products.storefront.products_per_page'));

            $perPage = isset($params['limit']) ? (! empty($params['limit']) ? $params['limit'] : 9) : current($pages);
        } else {
            $perPage = isset($params['limit']) && ! empty($params['limit']) ? $params['limit'] : 9;
        }

        $page = Paginator::resolveCurrentPage('page');

        $repository = app(ProductFlatRepository::class)->scopeQuery(function ($query) use ($params, $categoryId) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            $qb = $query->distinct()
                ->select('product_flat.*')
                ->join('product_flat as variants', 'product_flat.id', '=', DB::raw('COALESCE(' . DB::getTablePrefix() . 'variants.parent_id, ' . DB::getTablePrefix() . 'variants.id)'))
                ->leftJoin('product_categories', 'product_categories.product_id', '=', 'product_flat.product_id')
                ->leftJoin('product_attribute_values', 'product_attribute_values.product_id', '=', 'variants.product_id')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->whereNotNull('product_flat.url_key');

            if ($categoryId) {
                $qb->where('product_categories.category_id', $categoryId);
            }

            if (is_null(request()->input('status'))) {
                $qb->where('product_flat.status', 1);
            }

            if (is_null(request()->input('visible_individually'))) {
                $qb->where('product_flat.visible_individually', 1);
            }

            if (isset($params['search'])) {
                $qb->where('product_flat.name', 'like', '%' . urldecode($params['search']) . '%');
            }

            /* added for api as per the documentation */
            if (isset($params['name'])) {
                $qb->where('product_flat.name', 'like', '%' . urldecode($params['name']) . '%');
            }

            /* added for api as per the documentation */
            if (isset($params['url_key'])) {
                $qb->where('product_flat.url_key', 'like', '%' . urldecode($params['url_key']) . '%');
            }

            # sort direction
            $orderDirection = 'asc';
            if (isset($params['order']) && in_array($params['order'], ['desc', 'asc'])) {
                $orderDirection = $params['order'];
            } else {
                $sortOptions = $this->getDefaultSortByOption();
                $orderDirection = ! empty($sortOptions) ? $sortOptions[1] : 'asc';
            }

            if (isset($params['sort'])) {
                $this->checkSortAttributeAndGenerateQuery($qb, $params['sort'], $orderDirection);
            } else {
                $sortOptions = $this->getDefaultSortByOption();
                if (! empty($sortOptions)) {
                    $this->checkSortAttributeAndGenerateQuery($qb, $sortOptions[0], $orderDirection);
                }
            }

            if ($priceFilter = request('price')) {
                $priceRange = explode(',', $priceFilter);
                if (count($priceRange) > 0) {
                    $qb->where('variants.min_price', '>=', core()->convertToBasePrice($priceRange[0]));
                    $qb->where('variants.min_price', '<=', core()->convertToBasePrice(end($priceRange)));
                }
            }

            $attributeFilters = $this->attributeRepository
                ->getProductDefaultAttributes(array_keys(
                    request()->except(['price'])
                ));


            if (count($attributeFilters) > 0) {
                $qb->where(function ($filterQuery) use ($attributeFilters) {

                    foreach ($attributeFilters as $attribute) {
                        $filterQuery->orWhere(function ($attributeQuery) use ($attribute) {

                            $column = DB::getTablePrefix() . 'product_attribute_values.' . ProductAttributeValueProxy::modelClass()::$attributeTypeFields[$attribute->type];



                            $filterInputValues = explode(',', request()->get($attribute->code));

                            
                            # define the attribute we are filtering
                            $attributeQuery = $attributeQuery->where('product_attribute_values.attribute_id', $attribute->id);

                          

                            # apply the filter values to the correct column for this type of attribute.
                            if ($attribute->type != 'price') {

                                $attributeQuery->where(function ($attributeValueQuery) use ($column, $filterInputValues) {
                                    foreach ($filterInputValues as $filterValue) {
                                        if (! is_numeric($filterValue)) {
                                            continue;
                                        }
                                        $attributeValueQuery->orWhereRaw("find_in_set(?, {$column})", [$filterValue]);
                                    }
                                });

                            } else {
                                $attributeQuery->where($column, '>=', core()->convertToBasePrice(current($filterInputValues)))
                                    ->where($column, '<=', core()->convertToBasePrice(end($filterInputValues)));
                            }
                        });
                    }

                });

                # this is key! if a product has been filtered down to the same number of attributes that we filtered on,
                # we know that it has matched all of the requested filters.
                $qb->groupBy('variants.id');
                $qb->havingRaw('COUNT(*) = ' . count($attributeFilters));
            }

            return $qb->groupBy('product_flat.id');

        });

        # apply scope query so we can fetch the raw sql and perform a count
        $repository->applyScope();
        $countQuery = "select count(*) as aggregate from ({$repository->model->toSql()}) c";
        $count = collect(DB::select($countQuery, $repository->model->getBindings()))->pluck('aggregate')->first();

        if ($count > 0) {
            # apply a new scope query to limit results to one page
            $repository->scopeQuery(function ($query) use ($page, $perPage) {
                return $query->forPage($page, $perPage);
            });

            # manually build the paginator
            $items = $repository->get();
        } else {
            $items = [];
        }

         $data = request()->query();
        
        $results = new LengthAwarePaginator($items, $count, $perPage, $page, [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]);

        return $results;
    }

    /**
     * Retrive product from slug
     *
     * @param string $slug
     * @param string $columns
     *
     * @return \Webkul\Product\Contracts\Product
     */
    public function findBySlugOrFail($slug, $columns = null)
    {
        $product = app(ProductFlatRepository::class)->findOneWhere([
            'url_key' => $slug,
            'locale'  => app()->getLocale(),
            'channel' => core()->getCurrentChannelCode(),
        ]);

        if (! $product) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->model), $slug
            );
        }

        return $product;
    }

    /**
     * Retrieve product from slug without throwing an exception (might return null)
     *
     * @param string $slug
     *
     * @return \Webkul\Product\Contracts\ProductFlat
     */
    public function findBySlug($slug)
    {
        // print_r($slug);exit();
        return app(ProductFlatRepository::class)->findOneWhere([
            'url_key' => $slug,
            'locale'  => app()->getLocale(),
            'channel' => core()->getCurrentChannelCode(),
        ]);
    }

    // function for catalog and datasheet for product details
    public function findbySlugCustom($slug)
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) use ($slug) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->addSelect('products.catalog', 'products.datasheet')
                ->addSelect('product_attribute_values.integer_value', 'attribute_options.admin_name as brand_name', 'attribute_options.option_slug as brand_slug')
                ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                ->leftJoin('product_attribute_values', function ($join) {
                $join->on('product_attribute_values.product_id', '=' , 'product_flat.product_id');
                $join->where('product_attribute_values.integer_value','!=',null);
                $join->where('product_attribute_values.attribute_id','=', 25);
            })
                ->leftJoin('attribute_options', function ($join) {
                $join->on('attribute_options.id', '=' , 'product_attribute_values.integer_value');
                $join->where('attribute_options.attribute_id','=', 25);
            })
                ->where('url_key', $slug)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale);
        })->first();

        $attr = DB::table('product_attribute_values as pa')
            ->leftJoin('attributes as a','a.id','=','pa.attribute_id')
            ->leftJoin('attribute_options as o','o.id','=','pa.integer_value')
            ->select('pa.id as pid','pa.integer_value','a.id','a.code','a.admin_name as attribute_name','o.id as option_id','o.admin_name as option_name','o.option_slug')
            ->where('pa.integer_value','!=',null)
            ->where('pa.integer_value','!=',0)
            ->where('a.id','!=',25)
            ->where('pa.product_id',$results->product_id)
            ->get();

        $multiCategory = DB::table('product_flat')->distinct()
            ->addSelect('product_categories.category_id', 'product_categories.product_id', 'category_translations.name as category_name', 'category_translations.url_path as category_url_path')
            ->leftJoin('product_categories', function ($join) {
                $join->on('product_categories.product_id', '=' , 'product_flat.product_id');
                $join->where('product_categories.category_id','!=', 1);
            })
            ->leftJoin('category_translations', function ($join) {
                $join->on('category_translations.category_id', '=' , 'product_categories.category_id');
            })
            ->where('url_key', $slug)
            ->groupBy('category_translations.category_id')
            ->get();

        $basicDiscount = DB::table('cart_rules')->distinct()
            ->whereIn('id', [1,2,3])
            ->get();

        $bulkDiscount = DB::table('cart_rules')->distinct()
            ->whereIn('id', [4,5,6])
            ->get();

        $results->attributes = $attr;
        $results->categories = $multiCategory;
        $results->basicDiscount = $basicDiscount;
        $results->bulkDiscount = $bulkDiscount;

        return $results;
    }

    /**
     * Returns newly added product
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNewProducts()
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.new', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate(12);

        return $results;
    }

    /**
     * Returns featured product
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFeaturedProducts()
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate(12);

        return $results;
    }

    /*public function getFeaturedProductsImages($products_id)
    {
        print_r($products_id);exit();
        $results = app(ProductImageRepository::class)->scopeQuery(function ($query) {

            return $query->distinct()
                ->addSelect('product_images.*')
                ->where('product_images.product_id', $products_id)
                ;})->paginate(20);

        // echo "<pre>"; print_r($results); exit();

        return $results;
    }*/

    /**
     * Returns offer product
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOfferedProducts()
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->Join('catalog_rule_product_prices', 'catalog_rule_product_prices.product_id', '=', 'product_flat.product_id')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->where('catalog_rule_product_prices.ends_till', '>=', \DB::raw('NOW()'))
                ->whereNotNull('product_flat.url_key')
                ->groupBy('catalog_rule_product_prices.product_id');
               // ->inRandomOrder();
        })->paginate(12);

        return $results;
    }

    /**
     * Search Product by Attribute
     *
     * @param string $term
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchProductByAttribute($term)
    {
        $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

        $locale = request()->get('locale') ?: app()->getLocale();

        if (config('scout.driver') == 'algolia') {
            $results = app(ProductFlatRepository::class)->getModel()::search('query', function ($searchDriver, string $query, array $options) use ($term, $channel, $locale) {
                $queries = explode('_', $term);

                $options['similarQuery'] = array_map('trim', $queries);

                $searchDriver->setSettings([
                    'attributesForFaceting' => [
                        "searchable(locale)",
                        "searchable(channel)",
                    ],
                ]);

                $options['facetFilters'] = ['locale:' . $locale, 'channel:' . $channel];

                return $searchDriver->search($query, $options);
            })
                ->where('status', 1)
                ->where('visible_individually', 1)
                ->orderBy('product_id', 'desc')
                ->paginate(16);
        } else if (config('scout.driver') == 'elastic') {
            $queries = explode('_', $term);

            $results = app(ProductFlatRepository::class)->getModel()::search(implode(' OR ', $queries))
                ->where('status', 1)
                ->where('visible_individually', 1)
                ->where('channel', $channel)
                ->where('locale', $locale)
                ->orderBy('product_id', 'desc')
                ->paginate(16);
        } else {
            $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) use ($term, $channel, $locale) {
                return $query->distinct()
                    ->addSelect('product_flat.*')
                    ->where('product_flat.status', 1)
                    ->where('product_flat.visible_individually', 1)
                    ->where('product_flat.channel', $channel)
                    ->where('product_flat.locale', $locale)
                    ->whereNotNull('product_flat.url_key')
                    ->where(function ($subQuery) use ($term) {
                        $queries = explode('_', $term);

                        foreach (array_map('trim', $queries) as $value) {
                            $subQuery->orWhere('product_flat.name', 'like', '%' . urldecode($value) . '%')
                                ->orWhere('product_flat.short_description', 'like', '%' . urldecode($value) . '%');
                        }
                    })
                    ->orderBy('product_id', 'desc');
            })->paginate(16);
        }

        return $results;
    }

    /**
     * Returns product's super attribute with options
     *
     * @param \Webkul\Product\Contracts\Product $product
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSuperAttributes($product)
    {
        $superAttrbutes = [];

        foreach ($product->super_attributes as $key => $attribute) {
            $superAttrbutes[$key] = $attribute->toArray();

            foreach ($attribute->options as $option) {
                $superAttrbutes[$key]['options'][] = [
                    'id'           => $option->id,
                    'admin_name'   => $option->admin_name,
                    'sort_order'   => $option->sort_order,
                    'swatch_value' => $option->swatch_value,
                ];
            }
        }

        return $superAttrbutes;
    }

    /**
     * Search simple products for grouped product association
     *
     * @param string $term
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchSimpleProducts($term)
    {
        return app(ProductFlatRepository::class)->scopeQuery(function ($query) use ($term) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->addSelect('product_flat.product_id as id')
                ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                ->where('products.type', 'simple')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->where('product_flat.name', 'like', '%' . urldecode($term) . '%')
                ->orderBy('product_id', 'desc');
        })->get();
    }

    /**
     * Copy a product. Is usually called by the copy() function of the ProductController.
     *
     * Always make the copy is inactive so the admin is able to configure it before setting it live.
     *
     * @param int $sourceProductId the id of the product that should be copied
     */
    public function copy(Product $originalProduct): Product
    {
        $this->fillOriginalProduct($originalProduct);

        if (! $originalProduct->getTypeInstance()->canBeCopied()) {
            throw new Exception(trans('admin::app.response.product-can-not-be-copied', ['type' => $originalProduct->type]));
        }

        DB::beginTransaction();

        try {
            $copiedProduct = $this->persistCopiedProduct($originalProduct);

            $this->persistAttributeValues($originalProduct, $copiedProduct);

            $this->persistRelations($originalProduct, $copiedProduct);
        } catch (Exception $e) {
            DB::rollBack();

            report($e);

            throw $e;
        }

        DB::commit();

        return $copiedProduct;
    }

    /**
     * Get default sort by option
     *
     * @return array
     */
    private function getDefaultSortByOption()
    {
        $value = core()->getConfigData('catalog.products.storefront.sort_by');

        $config = $value ? $value : 'name-desc';

        return explode('-', $config);
    }

    /**
     * Check sort attribute and generate query
     *
     * @param object $query
     * @param string $sort
     * @param string $direction
     *
     * @return object
     */
    private function checkSortAttributeAndGenerateQuery($query, $sort, $direction)
    {
        $attribute = $this->attributeRepository->findOneByField('code', $sort);

        if ($attribute) {
            if ($attribute->code === 'price') {
                $query->orderBy('min_price', $direction);
            } else {
                $query->orderBy($sort === 'created_at' ? 'product_flat.created_at' : $attribute->code, $direction);
            }
        }

        return $query;
    }

    private function fillOriginalProduct(Product &$sourceProduct): void
    {
        $sourceProduct
            ->load('attribute_family')
            ->load('categories')
            ->load('customer_group_prices')
            ->load('inventories')
            ->load('inventory_sources');
    }

    /**
     * @param $originalProduct
     *
     * @return mixed
     */
    private function persistCopiedProduct($originalProduct): Product
    {
        $copiedProduct = $originalProduct
            ->replicate()
            ->fill([
                // the sku and url_key needs to be unique and should be entered again newly by the admin:
                'sku' => 'temporary-sku-' . substr(md5(microtime()), 0, 6),
            ]);

        $copiedProduct->save();

        return $copiedProduct;
    }


    /**
     * Gather the ids of the necessary product attributes.
     * Throw an Exception if one of these 'basic' attributes are missing for some reason.
     */
    private function gatherAttributeIds(): array
    {
        $ids = [];

        foreach (['name', 'sku', 'status', 'url_key'] as $code) {
            $ids[$code] = Attribute::query()->where(['code' => $code])->firstOrFail()->id;
        }

        return $ids;
    }

    private function persistAttributeValues(Product $originalProduct, Product $copiedProduct): void
    {
        $attributeIds = $this->gatherAttributeIds();

        $newProductFlat = new ProductFlat();

        // only obey copied locale and channel:
        if (isset($originalProduct->product_flats[0])) {
            $newProductFlat = $originalProduct->product_flats[0]->replicate();
        }

        $newProductFlat->product_id = $copiedProduct->id;

        $attributesToSkip = config('products.skipAttributesOnCopy') ?? [];

        $randomSuffix = substr(md5(microtime()), 0, 6);

        foreach ($originalProduct->attribute_values as $oldValue) {
            if (in_array($oldValue->attribute->code, $attributesToSkip)) {
                continue;
            }

            $newValue = $oldValue->replicate();

            // change name of copied product
            if ($oldValue->attribute_id === $attributeIds['name']) {
                $copyOf = trans('admin::app.copy-of');
                $copiedName = sprintf('%s%s (%s)',
                    Str::startsWith($originalProduct->name, $copyOf) ? '' : $copyOf,
                    $originalProduct->name,
                    $randomSuffix
                );
                $newValue->text_value = $copiedName;
                $newProductFlat->name = $copiedName;
            }

            // change url_key of copied product
            if ($oldValue->attribute_id === $attributeIds['url_key']) {
                $copyOfSlug = trans('admin::app.copy-of-slug');
                $copiedSlug = sprintf('%s%s-%s',
                    Str::startsWith($originalProduct->url_key, $copyOfSlug) ? '' : $copyOfSlug,
                    $originalProduct->url_key,
                    $randomSuffix
                );
                $newValue->text_value = $copiedSlug;
                $newProductFlat->url_key = $copiedSlug;
            }

            // change sku of copied product
            if ($oldValue->attribute_id === $attributeIds['sku']) {
                $newValue->text_value = $copiedProduct->sku;
                $newProductFlat->sku = $copiedProduct->sku;
            }

            // force the copied product to be inactive so the admin can adjust it before release
            if ($oldValue->attribute_id === $attributeIds['status']) {
                $newValue->boolean_value = 0;
                $newProductFlat->status = 0;
            }

            $copiedProduct->attribute_values()->save($newValue);

        }

        $newProductFlat->save();
    }

    /**
     * @param $originalProduct
     * @param $copiedProduct
     */
    private function persistRelations($originalProduct, $copiedProduct): void
    {
        $attributesToSkip = config('products.skipAttributesOnCopy') ?? [];

        if (! in_array('categories', $attributesToSkip)) {
            foreach ($originalProduct->categories as $category) {
                DB::table('product_categories')->insert([
                    'product_id'  => $copiedProduct->id,
                    'category_id' => $category->id,
                ]);
            }
        }

        if (! in_array('inventories', $attributesToSkip)) {
            foreach ($originalProduct->inventories as $inventory) {
                $copiedProduct->inventories()->save($inventory->replicate());
            }
        }

        if (! in_array('customer_group_pricces', $attributesToSkip)) {
            foreach ($originalProduct->customer_group_prices as $customer_group_price) {
                $copiedProduct->customer_group_prices()->save($customer_group_price->replicate());
            }
        }

        if (! in_array('images', $attributesToSkip)) {
            foreach ($originalProduct->images as $image) {
                $copiedProduct->images()->save($image->replicate());
            }
        }

        if (! in_array('super_attributes', $attributesToSkip)) {
            foreach ($originalProduct->super_attributes as $super_attribute) {
                $copiedProduct->super_attributes()->save($super_attribute);
            }
        }

        if (! in_array('bundle_options', $attributesToSkip)) {
            foreach ($originalProduct->bundle_options as $bundle_option) {
                $copiedProduct->bundle_options()->save($bundle_option->replicate());
            }
        }

        if (! in_array('variants', $attributesToSkip)) {
            foreach ($originalProduct->variants as $variant) {
                $variant = $this->copy($variant);
                $variant->parent_id = $copiedProduct->id;
                $variant->save();
            }
        }

        if (config('products.linkProductsOnCopy')) {
            DB::table('product_relations')->insert([
                'parent_id' => $originalProduct->id,
                'child_id'  => $copiedProduct->id,
            ]);
        }
    }

     public function findByBrandOption()
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate(12);

        return $results;
    }

     /**
     * Sets start and end date
     *
     * @return void
     */
    public function setStartEndDate()
    {
        $this->startDate = request()->get('start')
                           ? Carbon::createFromTimeString(request()->get('start') . " 00:00:01")
                           : Carbon::createFromTimeString(Carbon::now()->subDays(30)->format('Y-m-d') . " 00:00:01");

        $this->endDate = request()->get('end')
                         ? Carbon::createFromTimeString(request()->get('end') . " 23:59:59")
                         : Carbon::now();

        if ($this->endDate > Carbon::now()) {
            $this->endDate = Carbon::now();
        }

        $this->lastStartDate = clone $this->startDate;
        $this->lastEndDate = clone $this->startDate;

        $this->lastStartDate->subDays($this->startDate->diffInDays($this->endDate));
        // $this->lastEndDate->subDays($this->lastStartDate->diffInDays($this->lastEndDate));
    }

    public function getTopSellingProducts()
    {
        $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                    $locale = request()->get('locale') ?: app()->getLocale();

        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
                    $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                    $locale = request()->get('locale') ?: app()->getLocale();

                    return $query->distinct()
                        ->leftJoin('order_items', 'order_items.product_id', '=', 'product_flat.product_id')
                    ->select(DB::raw('SUM(qty_ordered) as total_qty_ordered'))
                    ->addSelect('product_flat.*')
                    ->where('product_flat.channel', $channel)
                    ->where('product_flat.locale', $locale)
                    ->where('order_items.created_at', '>=', $this->startDate)
                    ->where('order_items.created_at', '<=', $this->endDate)
                    ->whereNull('order_items.parent_id')
                    ->groupBy('order_items.product_id')
                    ->orderBy('total_qty_ordered', 'DESC');
                       // ->inRandomOrder();
                })->paginate(12);
                
                // echo "<pre>"; print_r($results); exit();

        return $results;


       /* return $this->orderItemRepository->getModel()
                    ->leftJoin('product_flat', 'order_items.product_id', '=', 'product_flat.product_id')
                    //->select(DB::raw('SUM(qty_ordered) as total_qty_ordered'))
                    ->addSelect('product_flat.*')
                    ->where('order_items.created_at', '>=', $this->startDate)
                    ->where('order_items.created_at', '<=', $this->endDate)
                    ->whereNull('order_items.parent_id')
                    ->groupBy('order_items.product_id')
                    //->orderBy('total_qty_ordered', 'DESC')
                    ->limit(5)
                    ->get();*/
    }

    public function findbySeller($id)
    {
        // $sellers = $this->model->where('role_id', 2)->get();
        $sellers = $this->model
        ->select('product_flat.id', 'product_flat.product_id', 'products.seller_id')
        ->leftJoin('product_flat', 'product_flat.product_id', '=', 'products.id')
        ->where('products.id', $id)
        ->get();

        return $sellers;
    }


    public function getFesivalProducts($id)
    {
        $results = $this->model
                    ->leftJoin('master_festival_products', 'products.id', 'master_festival_products.product_id')
                  // ->leftJoin('products', 'products.id', 'master_festival_products.product_id')
                   ->where('master_festival_products.parent_id', $id)
                   //->groupBy('master_festival_products.product_id')
                   ->get();

        return $results;
    }


    public function getFestivalProducts()
    {
       

          $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            $product_ids_arr = [];
            $now = Carbon::now();
            $dt = Carbon::now();
            $dt = $dt->toDateString();

            $product_ids = DB::table('master_festival')
                    ->leftJoin('master_festival_products', 'master_festival.id', 'master_festival_products.parent_id')
                   // ->leftJoin('product_flat', 'product_flat.product_id', 'master_festival_products.product_id')
                    ->select(DB::raw('group_concat(master_festival_products.product_id) as product_ids'))
                    //->select('product_flat.*','master_festival.title','master_festival.short_desc','master_festival.long_desc','master_festival.start_date','master_festival.end_date','master_festival.image')
                    ->whereDate('master_festival.start_date', '<=', $dt)
                    ->whereDate('master_festival.end_date', '>=', $dt)
                    ->where('master_festival.status', 1)
                    //->where('product_flat.status', 1)
                    //->groupBy('product_flat.product_id')
                    ->first();
                

                if (isset($product_ids) && !empty($product_ids) && !empty($product_ids->product_ids)) {
                    $product_ids_arr = explode(',', $product_ids->product_ids);
                }

               
                //echo $dt.":data<pre>"; print_r($product_ids_arr);exit();

            return $query->distinct()
                ->leftJoin('master_festival_products', 'product_flat.product_id', 'master_festival_products.product_id')
                ->leftJoin('master_festival', 'product_flat.product_id', 'master_festival_products.product_id')
                ->select('product_flat.*','master_festival.title','master_festival.short_desc','master_festival.long_desc','master_festival.start_date','master_festival.end_date','master_festival.image')
                ->where('master_festival.status', 1)
                //->where('master_festival.id', $data->id)
                ->whereIn('product_flat.product_id',$product_ids_arr)
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->where('master_festival.start_date', '<=', $now)
                //->where('master_festival.end_date', '<=', $this->endDate)
                ->where('master_festival.end_date', '>=', $now)
                ->whereNotNull('product_flat.url_key')
                ->groupBy('master_festival_products.product_id');
               // ->inRandomOrder();
        })->get();

        //echo"Festival product <pre>";print_r($results);exit();

        return $results;
    }


    
}