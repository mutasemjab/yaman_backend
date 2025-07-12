<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $user = auth()->user();
        $lang =  $user? $user->locale : 'en';
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->product->selling_price,
            'total_price' => $this->product->selling_price * $this->quantity,
            'coupon_discount' => $this->discount_coupon,
            //'delivery_price' => $this->delivery->price,
            'product' => new ProductResource($this->product),
            'variation' => new VariationResource($this->variation),

        ];
    }
}
