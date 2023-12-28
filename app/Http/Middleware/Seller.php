<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Seller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminMiddleware = new Admin();
        $user = auth()->user();

        if ($user->role == 'seller' || $adminMiddleware->handle($request , $next)->isOk()){
            return $next($request);
        }else{
            return back();
        }
    }
}
