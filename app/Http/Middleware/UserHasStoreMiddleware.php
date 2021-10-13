<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($store = auth()->user()->store) {
            flash('Você já possui uma loja!')->error();
            return redirect()->route('admin.stores.index');
        }
        return $next($request);
    }
}
