<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MultiTranslatableTrait
{
    /**
     * Set translations for the given model.
     *
     * @param array $data
     * @return void
     */
    public function setMultiTranslations(array $data): void
    {
        $locales = getLocalesCode();
        $fields = $this->translatable;
        foreach ($locales as $localeCode) {
            foreach ($fields as $field) {
                if (isset($data[$field][$localeCode])) {
                    $this->setTranslation($field, $localeCode, $data[$field][$localeCode]);
                }
            }
            // Handle slug separately if title is present
            if (isset($data['title'][$localeCode]) && in_array('slug', $fields)) {
                $this->setTranslation('slug', $localeCode, Str::slug($data['title'][$localeCode]));
            }
        }
    }
}
