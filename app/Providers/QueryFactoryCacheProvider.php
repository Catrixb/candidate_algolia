<?php

namespace App\Providers;

use App\Cache\QueryFactoryCache;
use App\Cache\CacheFactory;
use App\Config;
use App\QueryFileReducer;
use Illuminate\Support\ServiceProvider;

class QueryFactoryCacheProvider extends ServiceProvider 
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(QueryFactoryCache::class, function ($app) {
            $config = Config::self();
            $cacheSystem = $config->get('cache.system', CacheFactory::FILE);
            
            return new QueryFactoryCache(
                CacheFactory::getCache($cacheSystem),
                $config,
                new QueryFileReducer($config)
            );
        });
    }
}
