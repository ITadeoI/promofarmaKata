<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'discount' => $this->discount,
            'stock' => $this->isOutOfStock(),
            'finalPrice' => $this->priceWithDiscountApplied(),
            'rating' => $this->averageRating(),
            'href' => [
                'reviews' => route('reviews.index', $this->id)
            ]
        ];
    }

    /**
     * @return float|string
     */
    private function averageRating()
    {
        return $this->reviews->count() > 0 ?
            round($this->reviews->sum('star') / $this->reviews->count(), 2) :
            'Be first to review it!';
    }

    private function isOutOfStock()
    {
        return empty($this->stock) ? 'Out of Stock': $this->stock;
    }

    private function priceWithDiscountApplied()
    {
        return round((1 - ($this->discount/100)) * $this->price, 2);
    }
}
