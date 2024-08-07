<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Webkul\Product\Models\Product;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Webkul\Product\Helpers\ProductType;
use Webkul\Core\Contracts\Validations\Slug;
use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\User\Repositories\AdminRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Inventory\Repositories\InventorySourceRepository;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Product\Repositories\ProductAttributeValueRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Product\Mail\AdminProductEmail;
use File;
use Webkul\Product\Helpers\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use DispatchesJobs, ValidatesRequests;
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CategoryRepository object
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    protected $adminRepository;

    /**
     * ProductDownloadableLinkRepository object
     *
     * @var \Webkul\Product\Repositories\ProductDownloadableLinkRepository
     */
    protected $productDownloadableLinkRepository;

    /**
     * ProductDownloadableSampleRepository object
     *
     * @var \Webkul\Product\Repositories\ProductDownloadableSampleRepository
     */
    protected $productDownloadableSampleRepository;

    /**
     * AttributeFamilyRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeFamilyRepository
     */
    protected $attributeFamilyRepository;

    /**
     * InventorySourceRepository object
     *
     * @var \Webkul\Inventory\Repositories\InventorySourceRepository
     */
    protected $inventorySourceRepository;

    /**
     * ProductAttributeValueRepository object
     *
     * @var \Webkul\Product\Repositories\ProductAttributeValueRepository
     */
    protected $productAttributeValueRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Category\Repositories\CategoryRepository                 $categoryRepository
     * @param \Webkul\Product\Repositories\ProductRepository                   $productRepository
     * @param \Webkul\Product\Repositories\ProductDownloadableLinkRepository   $productDownloadableLinkRepository
     * @param \Webkul\Product\Repositories\ProductDownloadableSampleRepository $productDownloadableSampleRepository
     * @param \Webkul\Attribute\Repositories\AttributeFamilyRepository         $attributeFamilyRepository
     * @param \Webkul\Inventory\Repositories\InventorySourceRepository         $inventorySourceRepository
     * @param \Webkul\Product\Repositories\ProductAttributeValueRepository     $productAttributeValueRepository
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        AdminRepository $adminRepository,
        ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        AttributeFamilyRepository $attributeFamilyRepository,
        InventorySourceRepository $inventorySourceRepository,
        ProductAttributeValueRepository $productAttributeValueRepository
    )
    {
        $this->_config = request('_config');

        $this->categoryRepository = $categoryRepository;

         $this->productRepository = $productRepository;

        $this->adminRepository = $adminRepository;

        $this->productDownloadableLinkRepository = $productDownloadableLinkRepository;

        $this->productDownloadableSampleRepository = $productDownloadableSampleRepository;

        $this->attributeFamilyRepository = $attributeFamilyRepository;

        $this->inventorySourceRepository = $inventorySourceRepository;

        $this->productAttributeValueRepository = $productAttributeValueRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $families = $this->attributeFamilyRepository->all();

        $sellers = $this->adminRepository->allSeller();

        $configurableFamily = null;

        if ($familyId = request()->get('family')) {
            $configurableFamily = $this->attributeFamilyRepository->find($familyId);
        }

        return view($this->_config['view'], compact('families', 'configurableFamily', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (! request()->get('family')
            && ProductType::hasVariants(request()->input('type'))
            && request()->input('sku') != ''
        ) {
            return redirect(url()->current() . '?type=' . request()->input('type') . '&family=' . request()->input('attribute_family_id') . '&sku=' . request()->input('sku'));
        }

        if (ProductType::hasVariants(request()->input('type'))
            && (! request()->has('super_attributes')
                || ! count(request()->get('super_attributes')))
        ) {
            session()->flash('error', trans('admin::app.catalog.products.configurable-error'));

            return back();
        }

        $this->validate(request(), [
            'type'                => 'required',
            'attribute_family_id' => 'required',
            'sku'                 => ['required', 'unique:products,sku', new Slug],
        ]);

        $product = $this->productRepository->create(request()->all());

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect'], ['id' => $product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = $this->productRepository->with(['variants', 'variants.inventories'])->findOrFail($id);

        $sellers = $this->adminRepository->allSeller();

        $categories = $this->categoryRepository->getCategoryTree();

        $getTerm = $this->productRepository->getShippingTerm();
        // echo "<pre>"; print_r($getTerm); exit();

        $inventorySources = $this->inventorySourceRepository->findWhere(['status' => 1]);

        return view($this->_config['view'], compact('product', 'categories', 'inventorySources', 'sellers', 'getTerm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Webkul\Product\Http\Requests\ProductForm $request
     * @param int                                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductForm $request, $id)
    {

      //echo"<pre>request";  print_r(request()->all());exit();
        $data = request()->all();

        $old_data = $this->productRepository->with(['variants', 'variants.inventories'])->findOrFail($id);

        if (request()->hasFile('catalog'))
        {
            $docName = $data['catalog'];
            if (isset($old_data['catalog']) && !empty($old_data['catalog'])) {
               $file_path = public_path().'/'.$old_data['catalog'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $docName1 = time().'.'.$docName->extension();
            $docName->move(public_path('uploadImages/products/catalog'), $docName1);
            $data['catalog'] = 'uploadImages/products/catalog/'.$docName1;
        }

        if (request()->hasFile('datasheet'))
        {
            $docName = $data['datasheet'];
            if (isset($old_data['datasheet']) && !empty($old_data['datasheet'])) {
               $file_path = public_path().'/'.$old_data['datasheet'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $docName1 = time().'.'.$docName->extension();
            $docName->move(public_path('uploadImages/products/datasheet'), $docName1);
            $data['datasheet'] = 'uploadImages/products/datasheet/'.$docName1;
        }

        $multiselectAttributeCodes = array();

        $productAttributes = $this->productRepository->findOrFail($id);

        foreach ($productAttributes->attribute_family->attribute_groups as $attributeGroup) {
            $customAttributes = $productAttributes->getEditableAttributes($attributeGroup);

            if (count($customAttributes)) {
                foreach ($customAttributes as $attribute) {
                    if ($attribute->type == 'multiselect') {
                        array_push($multiselectAttributeCodes, $attribute->code);
                    }
                }
            }
        }

        if (count($multiselectAttributeCodes)) {
            foreach ($multiselectAttributeCodes as $multiselectAttributeCode) {
                if (! isset($data[$multiselectAttributeCode])) {
                    $data[$multiselectAttributeCode] = array();
                }
            }
        }

        $product = $this->productRepository->update($data, $id);

        // Mail to admin for sellers prosuct activation
        if(auth()->guard('admin')->user() && auth()->guard('admin')->user()->role->id != 1)
        {
            $toAdmin = ['id' => $id,
                        'sku' => $data['sku'],
                        'pname' => $data['name'],
                        'user_name' => auth()->guard('admin')->user()->name,
                        'user_email' => auth()->guard('admin')->user()->email,
                        'user_role' => auth()->guard('admin')->user()->role->name
                    ];

            try {
                    Mail::queue(new AdminProductEmail($toAdmin));

                    session()->flash('success', trans('admin::app.response.email-success', ['name' => 'Verification']));
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', trans('admin::app.response.email-error'));
            }
        }

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Uploads downloadable file
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadLink($id)
    {
        return response()->json(
            $this->productDownloadableLinkRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Copy a given Product.
     */
    public function copy(int $productId)
    {
        $originalProduct = $this->productRepository->findOrFail($productId);

        if (! $originalProduct->getTypeInstance()->canBeCopied()) {
            session()->flash('error',
                trans('admin::app.response.product-can-not-be-copied', [
                    'type' => $originalProduct->type,
                ]));

            return redirect()->to(route('admin.catalog.products.index'));
        }

        if ($originalProduct->parent_id) {
            session()->flash('error',
                trans('admin::app.catalog.products.variant-already-exist-message'));

            return redirect()->to(route('admin.catalog.products.index'));
        }

        $copiedProduct = $this->productRepository->copy($originalProduct);

        if ($copiedProduct instanceof Product && $copiedProduct->id) {
            session()->flash('success', trans('admin::app.response.product-copied'));
        } else {
            session()->flash('error', trans('admin::app.response.error-while-copying'));
        }

        return redirect()->to(route('admin.catalog.products.edit', ['id' => $copiedProduct->id]));
    }

    /**
     * Uploads downloadable sample file
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadSample($id)
    {
        return response()->json(
            $this->productDownloadableSampleRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findOrFail($id);

        try {
            $delete = $this->productRepository->delete($id);

            $this->deleteProductChild($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Product']));

            return response()->json(['message' => true], 200);
        } catch (Exception $e) {
            report($e);
            
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Product']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Mass Delete the products
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $productIds = explode(',', request()->input('indexes'));

        foreach ($productIds as $productId) {
            $product = $this->productRepository->find($productId);

            if (isset($product)) {
                $this->productRepository->delete($productId);
                $this->deleteProductChild($productId);
            }
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-delete-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Mass updates the products
     *
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        $data = request()->all();

        if (! isset($data['massaction-type'])) {
            return redirect()->back();
        }

        if (! $data['massaction-type'] == 'update') {
            return redirect()->back();
        }

        $productIds = explode(',', $data['indexes']);

        foreach ($productIds as $productId) {
            $this->productRepository->update([
                'channel' => null,
                'locale'  => null,
                'status'  => $data['update-options'],
            ], $productId);
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    public function deleteProductChild($id){

        try {

            // DB::table('products')
            //             ->where('id',$id)
            //             ->delete();

            DB::table('product_categories')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_relations')
                        ->where('parent_id',$id)
                        ->orWhere('child_id',$id)
                        ->delete();

            DB::table('product_super_attributes')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_up_sells')
                        ->where('parent_id',$id)
                        ->orWhere('child_id',$id)
                        ->delete();

            DB::table('product_cross_sells')
                        ->where('parent_id',$id)
                        ->orWhere('child_id',$id)
                        ->delete();

            DB::table('product_attribute_values')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_reviews')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_images')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_inventories')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_ordered_inventories')
                        ->where('product_id',$id)
                        ->delete();

            DB::table('product_downloadable_samples')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_downloadable_links')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_grouped_products')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_bundle_options')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_bundle_option_products')
                        ->where('product_id',$id)
                        ->delete();
            DB::table('product_customer_group_prices')
                        ->where('product_id',$id)
                        ->delete();
          
            DB::table('product_flat')
                        ->where('product_id',$id)
                        ->delete();

            return;

        } catch (Exception $e) {
             report($e);
            return;
        }
        
    }

    /**
     * To be manually invoked when data is seeded into products
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        Event::dispatch('products.datagrid.sync', true);

        return redirect()->route('admin.catalog.products.index');
    }

    /**
     * Result of search product.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function productLinkSearch()
    {
        if (request()->ajax()) {
            $results = [];

            foreach ($this->productRepository->searchProductByAttribute(request()->input('query')) as $row) {
                $results[] = [
                    'id'   => $row->product_id,
                    'sku'  => $row->sku,
                    'name' => $row->name,
                ];
            }

            return response()->json($results);
        } else {
            return view($this->_config['view']);
        }
    }

     public function productSearchBox()
    {
        //if (request()->ajax()) {
            $results = [];

            $productImageHelper = app('Webkul\Product\Helpers\ProductImage');
            
            foreach ($this->productRepository->searchProductByAttribute(request()->input('query')) as $row) {

                $image = $productImageHelper->getProductBaseImage($row);

                
                $results[] = [
                    'id'   => $row->product_id,
                    'sku'  => $row->sku,
                    'name' => $row->name,
                    //'row' => $row,
                    'image' => $image['small_image_url'],
                    'baseUrl'      => url('/'),
                    'url_key'      => $row->url_key,
                    'priceHTML' => $row->getTypeInstance()->getOfferPriceHtml(),
                ];
            }

            return response()->json($results);
        //} 
    }

    /**
     * Download image or file
     *
     * @param int $productId
     * @param int $attributeId
     *
     * @return \Illuminate\Http\Response
     */
    public function download($productId, $attributeId)
    {
        $productAttribute = $this->productAttributeValueRepository->findOneWhere([
            'product_id'   => $productId,
            'attribute_id' => $attributeId,
        ]);

        return Storage::download($productAttribute['text_value']);
    }

    /**
     * Search simple products
     *
     * @return \Illuminate\Http\Response
     */
    public function searchSimpleProducts()
    {
        return response()->json(
            $this->productRepository->searchSimpleProducts(request()->input('query'))
        );
    }
}