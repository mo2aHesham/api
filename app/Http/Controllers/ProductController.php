<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests\productRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  ProductCollection::collection(Product::paginate(5));
        //return  ProductResource::collection(Product::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(productRequest $request)
    //productRequest because i make validation there
    {
        $product =  Product::forceCreate(request()->all());
        //return $product;
        return response([
            'data' =>new ProductResource($product)
            ],Response::HTTP_CREATED);
        // another way to store data in database



        /*$product = new Product;
        $product->name= $request->name;
        $product->description= $request->description;
        $product->price= $request->price;
        $product->stock= $request->stock;
        $product->discount= $request->discount;
        $product->save();
        return $request->all();*/


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //return ($product);
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //return $request->all(); //return the new data
        //return $product; // return all request contain id,created_at,updated_at
        $product->update(request()->all()); // to updated it in database

        //return new ProductResource($product); // to see data in api
         return response([
            'data' =>new ProductResource($product)
            ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);

    }
     /*public function destroy($id)
    {
        return Product::find($id);
    }*/
}
