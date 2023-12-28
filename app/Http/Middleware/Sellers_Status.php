<?php

namespace App\Http\Middleware;

use App\Models\Seller_status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Sellers_Status
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id =auth()->id();
        $status=Seller_status::where('user_id' , $id)->first('status');

        if (auth()->user()->role == 'seller' && $status->status == 'not accepted'){
            Session::flash('seller_not_accepted' , 'منتظر تایید ادمین');
            return back();
        }else{
            return $next($request);
        }

    }
}
