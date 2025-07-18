<?php

namespace App\Traits;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

trait MenuTrait
{
    /**
     * Encode the given value as JSON.
     *
     * @param bool $status
     * @return void
     */
    public function setActive(bool $status): void
    {
        if ($this->menu()->exists()) {
            $this->menu()->each(function (MenuItem $menuItem) use ($status) {
                $menuItem->status = $status;
                $menuItem->save();

                $menuItem->parent()->each(function (MenuItem $child) use ($status) {
                    $child->parent_id = 0;
                    $child->depth = 0;
                    $child->save();
                });
            });
        }
    }
    /**
     * Encode the given value as JSON.
     *
     * @param bool $status
     * @return void
     */
    public function setForceDelete(bool $status): void
    {
        $this->menu()->each(function (MenuItem $menuItem) use ($status) {
            $menuItem->forceDelete();
            $menuItem->parent()->each(function (MenuItem $child) use ($status) {
                $child->parent_id = 0;
                $child->depth = 0;
                $child->save();
            });
        });
    }

    /**
     * Encode the given value as JSON.
     *
     * @param $data
     * @return void
     */
    public function setMenuTranslations($title, $slug): void
    {
        $this->menu()->each(function (MenuItem $menuItem) use ($title, $slug) {
            $menuItem->title = $title;
            $menuItem->slug = $slug;
            $menuItem->save();
        });
    }

    /**
     * Define the relationship with the MenuItem model.
     *
     * @return morphMany
     */
    public function menu(): morphMany
    {
        return $this->morphMany(MenuItem::class, 'model');
    }
}
