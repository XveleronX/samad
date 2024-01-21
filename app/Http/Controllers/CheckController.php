<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Http\Requests\StoreCheckRequest;
use App\Http\Requests\UpdateCheckRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $checks=Check::with('order')->get();
        $users= Order::with('user')->get();
        $products=Order::with('products')->get();


        return response()->json([
            'checks'=>$checks ,
            'users'=>$users ,
            'products' => $products
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders=Order::all();
        return response()->json([
            'orders'=>$orders
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckRequest $request)
    {

        Check::create([
            'order_id'=>$request->order_id,
        ]);
        return response()->json([
            'statuses'=>'success',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function pay(string $id)
    {
       /* Session::put('pay_status' , 'paid');*/
    Check::where('order_id' , $id)->update([
        'pay_status'=>'paid'
    ]);
        return response()->json([
            'statuses'=>'success',
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $checks=Check::find($id);
        $order_id = $checks->order_id;
        return response()->json([
        'statuses'=>'success',
        'id'=>$order_id
    ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCheckRequest $request, string $id)
    {
        /*Check::where('id' , $id)->update([
        'order_id'=>$request->order_id,
        ]);
        return redirect()->route('checks.index');*/
        $checks=Check::find($id);
        $order_id = $checks->order_id;
        return response()->json([
            'statuses'=>'success',
            'id'=>$order_id
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Check=Check::find($id);
        $Check->delete();

        return response()->json([
            'statuses'=>'success',
        ],200);
    }
}
