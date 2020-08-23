<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cart\CartItemCollection;
use App\Model\Cart;
use App\Model\CartItem;
use App\Model\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Create a new Cart
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
     * Cart shown with its products
     *
     * @param  \App\Model\Cart $cart
     * @param Request $request
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
     * Remove Cart resource from storage.
     *
     * @param  \App\Model\Cart $cart
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
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

    /**
     * Add Product inside the Cart
     *
     * @param Cart $cart
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProducts(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        if ($cart->key == $cartKey) {
            // Product exist or 404 not found
            try {$product = Product::findOrFail($productID);} catch (ModelNotFoundException $e) {
                return response()->json([
                    'data' => 'The Product you are trying to add does not exits'
                ], Response::HTTP_NOT_FOUND);
            }

            $cartItem = CartItem::where([
                    'cart_id' => $cart->getKey(),
                    'product_id' => $productID]
            )->first();

            // Product exist in the cart within true update quantity but create a new one
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where([
                        'cart_id' => $cart->getKey(),
                        'product_id' => $productID]
                )->update(['quantity' => $quantity]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->getKey(),
                    'product_id' => $productID,
                    'quantity' => $quantity
                ]);
            }

            return response()->json([
                'data' => 'Cart was updated with the given product successfully'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'data' => 'Cartkey provided is incorrect'
        ]);
    }


}
