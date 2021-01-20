<?php

namespace Custom\Offer\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Custom\Offer\Models\Offer;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OfferRepository extends Repository
{
    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

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
        App $app
    )
    {
        $this->attributeRepository = $attributeRepository;

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

    public function get($post_id)
    {
        return Post::find($post_id);
    }

    public function all()
    {
        return Offer::getAll();
    }

    public function getNewProducts()
    {
        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            
            return $query->distinct()
                ->addSelect('*')
                ->inRandomOrder();
        })->paginate(4);

        return $results;
    }
   
}