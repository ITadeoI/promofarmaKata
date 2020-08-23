<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cart\CartItemCollection;
use App\Http\Resources\Cart\CartItemResource;
use App\Model\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created Cart in storage and return the data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getAuthIdentifier();
        }

        $cart = Cart::create([
            'cart_id' => md5(uniqid(rand(), true)),
            'key' => md5(uniqid(rand(), true)),
            'user_id' => isset($userID) ? $userID : null
        ]);

        return response()->json([
            'data' => 'A new cart have been created for you!',
            'cartId' => $cart->cart_id,
            'cartKey' => $cart->key,
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $cartKey = $request->input('cartKey');

        if($cart->key == $cartKey) {

            return response()->json([
                'cart' => $cart->cart_id,
                'Items in Cart' => new CartItemCollection($cart->items),
            ],Response::HTTP_OK);
        }

        return response()->json([
            'data' => 'CartKey provided is incorrect'
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Cart $cart
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $cartKey = $request->input('cartKey');

        if($cart->key == $cartKey) {

            $cart->delete();

            return response()->json(null,Response::HTTP_OK);
        }

        return response()->json([
            'data' => 'CartKey provided is incorrect'
        ],Response::HTTP_BAD_REQUEST);
    }
}
