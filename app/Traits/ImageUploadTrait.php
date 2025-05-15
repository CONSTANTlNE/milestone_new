<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUploadTrait
{
    /**
     * Process and save images for the model.
     *
     * @param Request $request
     * @param mixed $model
     * @return void
     */
    public function processAndSaveImages($data, mixed $model): void
    {
        $images = [];
        if(@$data['images']){
            $data['images'] = @$data['images'] ?: [];
            $mainImage_id = empty($data['mainImage_id']) ? 0 : 1;
            foreach ($data['images'] as $key => $value){
                $images[$value]['ord'] = $key+1;
                $images[$value]['cover'] = $data['cover'][$key+$mainImage_id];
            }
        }

        if(@$data['mainImage_id']){
            $data['mainImage_id'] = @$data['mainImage_id'] ?: [];
            $images[$data['mainImage_id']]['ord'] = 0;
            $images[$data['mainImage_id']]['cover'] = $data['cover'][0];
        }

        // Sync images with the model
        $model->images()->sync($images);
    }
}
