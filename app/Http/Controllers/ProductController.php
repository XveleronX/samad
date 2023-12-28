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
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $products=Product::all();

        return view('first_project.products.productsData' , ['products' => $products] );
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
        return redirect()->route('products.index');
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
    public function edit(string $id): view
    {
        $product=Product::find($id);
        $product->save();
        return view('first_project.products.editProductMenue' , ['product'=> $product] );
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
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Product=Product::find($id);
        $Product->delete();

        return back();
    }
}
