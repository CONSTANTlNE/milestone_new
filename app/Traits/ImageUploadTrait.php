<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\File;
trait ImageUploadTrait
{
    /**
     * Process and save images for the model.
     *
     * @param $data
     * @param mixed $model
     * @return void
     */
    public function processAndSaveImages($data, mixed $model, bool $image = false): void
    {
        $images = [];
        if (@$data['images']) {
            $data['images'] = @$data['images'] ?: [];
            $mainImage_id = empty($data['mainImage_id']) ? 0 : 1;

            foreach ($data['images'] as $key => $value) {
                $images[$value]['position'] = $key + 1;
                $images[$value]['cover'] = $data['cover'][$key + $mainImage_id];
            }
        }

        if (@$data['mainImage_id']) {
            $data['mainImage_id'] = @$data['mainImage_id'] ?: [];
            $images[$data['mainImage_id']]['position'] = 0;
            $images[$data['mainImage_id']]['cover'] = $data['cover'][0];
        }

        if (@$data['mainImage_id'] && $image) {
            $model->src = File::find($data['mainImage_id'])->src;
        } else {
            $model->src = null;
        }
        $model->save();

        // Sync images with the model
        $model->images()->sync($images);
    }
}
