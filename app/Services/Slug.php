<?php
namespace App\Services;
use Illuminate\Support\Str;

class Slug
{
    public function createSlug($titles, $langs, $id, $model)
    {
        $combinedTitles = $this->getCombinedAsArray($titles, $langs);

        if(!empty($combinedTitles['en'])){
            $langSlug = Str::slug($combinedTitles['en'], '-');
        }else{
            $langSlug = $this->ctl_sanitize_title($combinedTitles);
        }

        $allSlugs = $this->getRelatedSlugs($model, $langSlug, $id);

        if (! $allSlugs->contains('slug', $langSlug)){

            return $langSlug;
        }

        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $langSlug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }
    protected function getRelatedSlugs($model, $langSlug, $id)
    {
        $reflectionClass = new \ReflectionClass($model);
        $reflection = $reflectionClass->newInstanceArgs();

        return $reflection->select('slug')->where('slug', 'like', $langSlug.'%')->where('id', '<>', $id)->get();
    }

    protected function ctl_sanitize_title($combinedTitles)
    {
        $title = $combinedTitles["ka"];
        $geo2lat = array(
            'ა' => 'a', 'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v',
            'ზ' => 'z', 'თ' => 'th', 'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm',
            'ნ' => 'n', 'ო' => 'o', 'პ' => 'p','ჟ' => 'zh','რ' => 'r','ს' => 's',
            'ტ' => 't','უ' => 'u','ფ' => 'ph','ქ' => 'q','ღ' => 'gh','ყ' => 'qh',
            'შ' => 'sh','ჩ' => 'ch','ც' => 'ts','ძ' => 'dz','წ' => 'ts','ჭ' => 'tch',
            'ხ' => 'kh','ჯ' => 'j','ჰ' => 'h'
        );

        $term = '';
        if (empty($term) ) {
            $title = strtr($title, $geo2lat);
            $title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
            $title = preg_replace('/\-+/', '-', $title);
            $title = preg_replace('/^-+/', '', $title);
            $title = preg_replace('/-+$/', '', $title);
        } else {
            $title = $term;
        }
        return $title;
    }

    protected function getCombinedAsArray($titles, $langs)
    {

        $combinedAsArray = [];
        foreach ($titles as $key => $value){

            if (array_key_exists($key, $langs)){
                $combinedAsArray[$langs[$key]] = $value;
            }else{
                $combinedAsArray[$langs[$key]] = $value;
            }
        }
        return $combinedAsArray;
    }
}
