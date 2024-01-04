<?php

namespace App\Http\Controllers;
use App\Models\Check;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class OrderController extends Controller
{
    public function filter(Request $request)
    {
        $order_title=$request->filterTitle;
        $user_name=$request->filterUserName;
        $price_min=$request->filterTotal_priceMin;
        $price_max=$request->filterTotal_priceMax;

        $orders=Order::with('user')
            ->when($order_title , function ($query) use ($order_title){
                $query->where('title' , $order_title);
            })
            ->when($user_name , function ($query) use ($user_name){
                $query->whereHas('user', function ($subquery) use ($user_name) {
                    $subquery->where('user_name', '=', $user_name);});
            })
            ->when($price_min , function ($query) use ($price_min){
                $query->where('total_price', '>=' , $price_min);
            })
            ->when($price_max , function ($query) use ($price_max){
                $query->where('total_price', '<=' , $price_max);
            })
            ->get();


        return view('first_project.orders.ordersData' , ['orders' => $orders]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        if (auth()->user()->role == 'user'){
            $id=auth()->id();

            $orders=Order::with('products')->where('user_id' , $id)->get();
            return view('first_project.orders.ordersData' , ['orders' => $orders]);

        }elseif(auth()->user()->role == 'seller'){
        $id=Check::where('pay_status' , 'paid')->get('order_id');

        $orders=Order::with('products')->get();

        return view('first_project.orders.ordersData' , ['orders' => $orders , 'ids' => $id]);
        }else{
            $status=Check::all();

            $orders=Order::with('products')->get();

            return view('first_project.orders.ordersData' , ['orders' => $orders , 'statuses'=>$status]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        if (auth()->user()->role == 'user'){
            $id=auth()->id();
            $customers=User::find($id);
            /*dd($customers);*/
            $products_available=Product::all();
            return view('first_project.orders.addOrder' , ['customers'=> $customers, 'products_available'=>$products_available]);
        }else{
            $customers=User::all();
            $products_available=Product::all();
            return view('first_project.orders.addOrder' , ['customers'=> $customers, 'products_available'=>$products_available]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products=Product::all();

        $data=$request->all();
        $poc= [];
        $total_price=0;
       foreach ($products as $product){
        foreach ($data as $key=>$value ){
            if ($product->id == $key){
                $price=$product->price;
                //در اینجا اسم اینپوت ما $key می باشد و $request->$key مقدار ان اینپوت را میگیرد
                $amount=$request->$key;
                $sum=$price * $amount;
                $total_price+=$sum;
                $pc=array('product_id'=>$product->id , 'count'=>$amount);
            }
        }
        $poc [] = $pc;

       }

        $Order=Order::create([
            'user_id'=>$request->customer_id,
            'title'=>$request->order_name,
            'total_price'=>$total_price,
            ]);

        foreach ($poc as $po){
            if($po['count']>0){
            $Order->products()->attach($po['product_id'] , ['count'=>$po['count']]);
            }
        }

        return redirect()->route('orders.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): view
    {
        $customers=User::all();
        $products=Product::all();
        $order=Order::find($id);

        //$order->save();
        return view('first_project.orders.editOrderMenue' , ['order'=> $order, 'customers'=>$customers , 'products' => $products] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products=Product::all();
        $data=$request->all();
        $poc=[];
        $total_price=0;
        foreach ($products as $product){
            foreach ($data as $key=>$value ){
                if ($product->id == $key){
                    $price=$product->price;
                    $amount=$request->$key;
                    $sum=$price * $amount;
                    $total_price+=$sum;
                    $count=(int)$amount;
                    $pc=array('product_id'=>$product->id , 'count'=>$count );
                }
            }
            $poc []=$pc;
        }
        $orders=Order::find($id);
        $orders->total_price=$total_price;
        foreach ($poc as $key=>$po){
            if($key==0){
                $orders->products()->syncwithPivotValues([$po['product_id']] , ['count'=>$po['count']]);
            }else {
                $orders->products()->attach([$po['product_id']], ['count' => $po['count']]);
            }
    }
        $orders->save();

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order=Order::find($id);
        $order->delete();
        return back();
    }
}
