<?php

namespace App\Traits;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait SeoTrait
{
    /**
     * Set SEO translations for the model.
     *
     * @param array $seoData
     * @return void
     */
    public function setSeoTranslations(array $seoData): void
    {
        if (count(is_not_null($seoData['seoTitles']))) {
            $locales = getLocalesCode();
            $seo = new Seo();
            foreach ($locales as $localeCode) {
                $seo->setTranslation('seoTitles', $localeCode, $seoData['seoTitles'][$localeCode]);
                $seo->setTranslation('seoKeywords', $localeCode, $seoData['seoKeywords'][$localeCode]);
                $seo->setTranslation('seoDescriptions', $localeCode, $seoData['seoDescriptions'][$localeCode]);
            }
            // Save or update the SEO model
            $this->seo()->save($seo);
        }
    }

    /**
     * Define the relationship with the SEO model.
     *
     * @return morphMany
     */
    public function seo(): morphMany
    {
        return $this->morphMany(Seo::class, 'seoable');
    }
}
