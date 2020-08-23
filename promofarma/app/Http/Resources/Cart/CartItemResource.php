<?php

namespace App\Http\Resources\Cart;

use App\Model\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = Product::find();

        return [
            'name' => $product['name'],
            'description' => $product->detail,
            'price' => $product->price,
            'discount' => $product->discount,
            'href' => [
                'reviews' => route('reviews.index', $product->id)
            ]
        ];
    }
}
