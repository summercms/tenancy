<?php

declare(strict_types=1);

use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Tenancy;

if (! function_exists('tenancy')) {
    /** @return Tenancy */
    function tenancy()
    {
        return app(Tenancy::class);
    }
}

if (! function_exists('tenant')) {
    /**
     * Get a key from the current tenant's storage.
     *
     * @param string|null $key
     * @return Tenant|mixed
     */
    function tenant($key = null)
    {
        if (is_null($key)) {
            return app(Tenant::class);
        }

        return optional(app(Tenant::class))->get($key) ?? null;
    }
}

if (! function_exists('tenant_asset')) {
    /** @return string */
    function tenant_asset($asset)
    {
        return route('stancl.tenancy.asset', ['path' => $asset]);
    }
}

if (! function_exists('global_asset')) {
    function global_asset($asset)
    {
        return app('globalUrl')->asset($asset);
    }
}

if (! function_exists('global_cache')) {
    function global_cache()
    {
        return app('globalCache');
    }
}

if (! function_exists('tenant_route')) {
    function tenant_route($route, $parameters = [], string $domain = null)
    {
        $domain = $domain ?? request()->getHost();

        // replace first occurance of hostname fragment with $domain
        $url = route($route, $parameters);
        $hostname = parse_url($url, PHP_URL_HOST);
        $position = strpos($url, $hostname);

        return substr_replace($url, $domain, $position, strlen($hostname));
    }
}
