<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheableTrait
{
    /**
     * Add a new item to the cached collection or create a new cache if it doesn't exist.
     *
     * @param string $cacheKey
     * @param mixed $item
     * @param int $ttl
     */
    public function addToCacheCollection(string $cacheKey, mixed $item, int $ttl): void
    {
        $collection = Cache::get($cacheKey, collect());
        $collection->push($item);
        Cache::put($cacheKey, $collection, $ttl);
    }

    /**
     * Update or add an item to a cached collection.
     *
     * @param string $cacheKey
     * @param mixed $item
     * @param int $ttl
     * @return void
     */
    public function updateCachedCollection(string $cacheKey, mixed $item, int $ttl): void
    {
        $collection = Cache::get($cacheKey, collect());

        $index = $collection->search(fn($cachedItem) => $cachedItem->id === $item->id);

        if ($index !== false) {
            $collection->put($index, $item);
        } else {
            $collection->push($item);
        }

        Cache::put($cacheKey, $collection, $ttl);
    }

    /**
     * Delete an item from a cached collection.
     *
     * @param string $cacheKey
     * @param mixed $itemId
     * @param int $ttl
     * @return void
     */
    public function deleteCachedCollection(string $cacheKey, mixed $itemId, int $ttl): void
    {
        $collection = Cache::get($cacheKey, collect());

        $updatedCollection = $collection->reject(fn($item) => $item->id === $itemId);

        Cache::put($cacheKey, $updatedCollection, $ttl);
    }

    public static function getAllCached()
    {
        $instance = new static;
        $allCacheKey = $instance->getAllCacheKey();

        return Cache::remember($allCacheKey, 600, function () {
            return static::all();
        });
    }

    public function getCacheKey(): string
    {
        return static::class . '_' . $this->getKey();
    }

    public function getAllCacheKey(): string
    {
        return static::class . '_all';
    }
}
