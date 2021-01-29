<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
       //1 **************************
        // if(isset(request()->search)){
        //     return Product::where('name','like',"%".request()->search."%")->orderBy('id','desc')->paginate(5);
        // }else{
        //     return Product::orderBy('id','desc')->paginate(5);
        // }
      //2 query *************************
        //   $product = Product::query();
        //    if(isset(request()->search)){
        //         return $product->where('name','like',"%".request()->search."%")->orderBy('id','desc')->paginate(5);
        //     }else{
        //         return $product->orderBy('id','desc')->paginate(5);
        //     }
       //3******************
        return Product::when(request()->search,function($query){
             $query->where('name','like',"%".request()->search."%")->orderBy('id','desc')->paginate(5);
        })->orderBy('id','desc')->paginate(5);
    }

    public function store(ProductStoreRequest $request)
    {
    ## Database insert Method 1
        /**  $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->save();
            return $product;*/
     ## Database insert Method 2
            /**  $product = Product::create([
             "name"=>$request->name,
            "price"=>$request->price
            ]);
            return $product;*/
     ## Database insert Method 3
        // $product = Product::create($request->all());    // should not write security issue
    ## Database insert Method 4

       $product = Product::create($request->only("name","price"));
       return $product;
    }

    public function show(Product $product)
    {
        //return Product::find($id);//route model binding
        return $product;
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {

        // $product = Product::find($id);//route model binding
        $product->update($request->only("name","price"));
        return $product;

        ## long method;
         /**  $product = Product::find($id);
          $product->name = $request->name;
          $product->price = $request->price;
          $product->save();*/
    }

    public function destroy(Product $product)
    {
        // $product = Product::find($id); //route model binding
        $product->delete();
        return $product;
    }
}
