<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function filter(Request $request)
    {
        $product_name=$request->filterName;
        $price_min=$request->filterPriceMin;
        $price_max=$request->filterPriceMax;
        $inventory_min=$request->filterInventoryMin;
        $inventory_max=$request->filterInventoryMax;

        $productsQuery=Product::query();
        if (!is_null($product_name)){
            $productsQuery->where('titel' , $product_name);
        }
        if (!is_null($price_min)){
            $productsQuery->where('price', '>=' , $price_min);
        }
        if (!is_null($price_max)){
            $productsQuery->where('price', '<=' , $price_max);
        }
        if (!is_null($inventory_min)){
            $productsQuery->where('inventory','>=' , $inventory_min);
        }
        if (!is_null($inventory_max)){
            $productsQuery->where('inventory', '<=' , $inventory_max);
        }
        $products= $productsQuery->get();

        return response()->json([
            'statuses'=>'success',
            'products' => $products
        ],200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();

        return response()->json([
            'statuses'=>'success',
            'products' => $products
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        return view('first_project.products.addProduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
       $Product= new Product;
        $Product->titel= $request->product_name;
          $Product->price= $request->price;
          $Product->inventory= $request->amount_available;
          $Product->description=$request->explanation;
        $Product->save();
        return response()->json([
            'statuses'=>'success',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=Product::find($id);
        $product->save();
        return response()->json([
            'statuses'=>'success',
            'product'=> $product
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $Product=Product::find($id);
        $Product->titel= $request->product_name;
        $Product->price= $request->price;
        $Product->inventory= $request->amount_available;
        $Product->description=$request->explanation;
        $Product->save();
        return response()->json([
        'statuses'=>'success',
    ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Product=Product::find($id);
        $Product->delete();

        return response()->json([
            'statuses'=>'success',
        ],200);
    }
}
