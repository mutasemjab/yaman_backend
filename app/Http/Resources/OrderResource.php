<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Refund;
use App\Models\WholesaleOffer;
use App\Http\Controllers\Api\v1\User\CouponController;
use App\Models\User;
use App\Models\Product;
use App\Http\Resources\RefundResource;
use App\Models\Offer;
use Illuminate\Support\Facades\Route;


class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth()->user();
        $lang =  $user? $user->locale : 'en';
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_prices' => $this->total_prices,
            'status' => $this->order_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order_items' => ProductResource::collection($this->products),
            'delivery_fee' => $this->delivery_fee,
            ];
    }
}
