<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    return Product::orderBy('id', 'desc')->paginate(5);
        // if(request('search')){
        //     return Product::where('name', 'like', '%' . request('search') . '%')->get();
        // }else{
        //     return Product::orderBy('id', 'DESC')->get();
        // }

        // $products = Product::query();
        // if(request('search')){
        //    return $products->where('name', 'like', '%' . request('search') . '%')->get();
        // }else{
        //     return $products->orderBy('id', 'desc')->get();
        // }


        return Product::when(request('search'), function($query){
            $query->where('name', 'like', '%' . request('search') . '%')->paginate(5);
        })->orderBy('id', 'desc')->paginate(5);




    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {  
        $product = Product::create($request->only('name', 'price'));
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *                                      
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {   
       
        $product->update($request->only('name', 'price'));
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return "success Deleted";
    }
}
