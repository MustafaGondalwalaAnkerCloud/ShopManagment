<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DecryptMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        if ($route != null) {
            foreach ($request->route()->parameters() as $key => $param) {
                $update_param = decrypt_param($param);
                $route->setParameter($key, $update_param);
            }
        }
        foreach ($request->all() as $key => $element) {
            if (gettype($element) == 'array') {
                continue;
            }
            $update_param = decrypt_param($element);
            $request[$key] = $update_param;
        }

        return $next($request);
    }
}
