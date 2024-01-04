<?php

namespace App\Http\Middleware;

use App\Models\Check;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class PayStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ): Response
    {

        $id = $request->route('id');
        $status=Check::where('order_id' , $id)->first('pay_status');
        if ($status && $status->pay_status == 'paid'){
            Session::flash('paid' , 'you have paid your factor');
            return back();
        }else{
            return $next($request);
        }

    }

}
