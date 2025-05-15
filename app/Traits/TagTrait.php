<?php

namespace App\Traits;

use App\Models\Tag;
use Str;

trait TagTrait
{
    /**
     * Set SEO translations for the model.
     *
     * @param array $tagData
     * @return void
     */
    public function setTagTranslations(array $tagData): void
    {
        if (count(is_not_null($tagData['tags']))) {
            $tags = new Tag();
            $tagIds = [];
            foreach ($tagData['tags'] as $lang => $tagLangs) {
                foreach ($tagLangs as $tagName) {
                $tagName = trim($tagName);
                    if (!empty($tagName)) {
                        $tag = Tag::firstOrCreate([
                            'title' => $tagName,
                            'lang' => $lang,
                            'slug' => Str::slug($tagName)
                        ]);
                        $tagIds[] = $tag->id;
                    }
                }
            }
            $this->tags()->sync($tagIds);
        }
    }
}
