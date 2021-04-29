<?php

namespace Webkul\Attribute\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Webkul\Attribute\Repositories\AttributeRepository;
use File;

class AttributeController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @return void
     */
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;

        $this->_config = request('_config');
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
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'code'       => ['required', 'unique:attributes,code', new \Webkul\Core\Contracts\Validations\Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        $data = request()->all();

        //echo "<pre>";print_r($data);exit();

        if (isset($data['options'])) {
            foreach ($data['options'] as $optionId => $optionInputs) {
                $admin_name = str_replace(' ', '-', $optionInputs['admin_name']);
                $option_slug = strtolower($admin_name);
                $data['options'][$optionId]['option_slug'] = $option_slug;
            }
        }

        $data['is_user_defined'] = 1;

        $attribute = $this->attributeRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Attribute']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $attribute = $this->attributeRepository->findOrFail($id);

        return view($this->_config['view'], compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'code'       => ['required', 'unique:attributes,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        $data = request()->all();

        if (isset($data['options'])) {
            foreach ($data['options'] as $optionId => $optionInputs) {
                $admin_name = str_replace(' ', '-', $optionInputs['admin_name']);
                $option_slug = strtolower($admin_name);
                $data['options'][$optionId]['option_slug'] = $option_slug;

                foreach ($data['options'] as $opt_Id => $opt_Input) {
                    if(isset($option_slug) && isset($data['options'][$opt_Id]['option_slug']))
                    {
                        if($data['options'][$opt_Id]['option_slug'] == $option_slug && $opt_Id != $optionId) {
                            $original = $option_slug;
                            $split = explode('-', $original); // Split String
                            $lastIndex = count($split) - 1; // Find lastIndex of array
                            if(is_numeric($split[$lastIndex])) {
                                $count = $split[$lastIndex] + 1; // incrementing last number of array
                                $split[$lastIndex] = $count;
                                $option_slug = implode('-', $split);
                            } else {
                                $option_slug = "{$original}-" . 1;
                            }
                        }
                    }
                }

                $data['options'][$optionId]['option_slug'] = $option_slug;
                
                $brandLogo = isset($optionInputs['brand_logo']);
                $old_attribute = $this->attributeRepository->findatrOption($optionId);
                if($brandLogo != null)
                {
                    $brandLogo = $optionInputs['brand_logo'];
                    if(isset($old_attribute['brand_logo']) && $old_attribute['brand_logo'] != null)
                    {
                        $file_path = public_path().'/'.$old_attribute['brand_logo'];
                        if(File::exists($file_path)) 
                        {
                            unlink($file_path);
                        }
                    }

                    $imageName1 = time().rand(10,100).'.'.$brandLogo->extension();
                    $brandLogo->move(public_path('uploadImages/brandLogo'), $imageName1);
                    $data['options'][$optionId]['brand_logo'] = 'uploadImages/brandLogo/'.$imageName1;
                }
            }
        }

        $attribute = $this->attributeRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Attribute']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = $this->attributeRepository->findOrFail($id);

        if (! $attribute->is_user_defined) {
            session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Attribute']));
        } else {
            try {
                $this->attributeRepository->delete($id);

                session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Attribute']));

                return response()->json(['message' => true], 200);
            } catch(\Exception $e) {
                session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Attribute']));
            }
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Remove the specified resources from database
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            $indexes = explode(',', request()->input('indexes'));

            foreach ($indexes as $key => $value) {
                $attribute = $this->attributeRepository->find($value);

                try {
                    if ($attribute->is_user_defined) {
                        $suppressFlash = true;

                        $this->attributeRepository->delete($value);
                    }
                } catch (\Exception $e) {
                    report($e);

                    $suppressFlash = true;

                    continue;
                }
            }

            if ($suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'attributes']));
            } else {
                session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Attribute']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
