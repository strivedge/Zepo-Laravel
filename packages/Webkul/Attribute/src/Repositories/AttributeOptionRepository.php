<?php

namespace Webkul\Attribute\Repositories;

use Webkul\Core\Eloquent\Repository;
use DB;

class AttributeOptionRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Attribute\Contracts\AttributeOption';
    }

    /**
     * @param  array  $data
     * @return  \Webkul\Attribute\Contracts\AttributeOption
     */
    public function create(array $data)
    {
        $option = parent::create($data);

        $this->uploadSwatchImage($data, $option->id);

        return $option;
    }

    public function findbySlug($optionId, $option_slug)
    {
        $slug = DB::table('attribute_options')
        ->where('id','!=', $optionId)
        ->where('option_slug', $option_slug)->get();
        // $slug = $this->where('option_slug', 'johnson-&-johnson');
        // echo "<pre>"; print_r($slug); exit();
        return $slug;
    }

    /**
     * @param  array   $data
     * @param  int     $id
     * @param  string  $attribute
     * @return  \Webkul\Attribute\Contracts\AttributeOption
     */
    public function update(array $data, $id, $attribute = "id")
    {

        $option = parent::update($data, $id);

        $this->uploadSwatchImage($data, $id);

        return $option;
    }

    /**
     * @param  array  $data
     * @param  int  $optionId
     * @return void
     */
    public function uploadSwatchImage($data, $optionId)
    {
        if (! isset($data['swatch_value']) || ! $data['swatch_value']) {
            return;
        }

        if ($data['swatch_value'] instanceof \Illuminate\Http\UploadedFile) {
            parent::update([
                'swatch_value' => $data['swatch_value']->store('attribute_option'),
            ], $optionId);
        }
    }

    
}