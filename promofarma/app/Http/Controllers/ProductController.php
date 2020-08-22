<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;

        $product->name = $request->name;

        $product->detail = $request->description;

        $product->stock = $request->stock;

        $product->price = $request->price;

        $product->discount = $request->discount;

        $product->save();

        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Product $product
     * @return array
     */
    public function update(Request $request, Product $product)
    {
        $this->ProductOwnerCheck($product);

        $product->update($request->all());

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product $product
     * @return Product
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $this->ProductOwnerCheck($product);

        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function ProductOwnerCheck(Product $product)
    {
        if(Auth::id() != $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }
}
