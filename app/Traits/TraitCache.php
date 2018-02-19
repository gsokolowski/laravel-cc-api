<?php

namespace App\Traits;


use Illuminate\Support\Facades\Cache;

trait TraitCache
{
    protected function getCacheKey() {
        return request()->url();
    }

    protected function cacheIfNotCachedAndGetCollection($key, $data) {
        // rememberForever stores a default value under key if the requested item doesn't exist,
        // and returns data as collection
        $data = Cache::rememberForever($key, function() use($data) {
            return $data;
        });

        return $data;
    }

    // remove cache on key
    protected function forgetCache($key) {
        Cache::forget($key);
    }
}