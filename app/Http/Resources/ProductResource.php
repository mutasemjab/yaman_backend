<?php

namespace App\Http\Resources;

use App\Models\Favorite;
use App\Models\Admin;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Auth;

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
        $token = $request->bearerToken();
        $user = null;
        $lang =  $user? $user->locale : 'en';
        if ($token) {
            $user = Auth::guard('user-api')->user();
            return [
                "id" => $this->id,
                "category_id" => $this->category_id,
                "name" => $this->getTranslation('name', $lang),
                "photo" => $this->productImages->first()->photo,
                "photos" => $this->productImages,
                "has_variation" => $this->has_variation,
                "attribute" => $this->attribute,
                "available_qty" => $this->available_quantity,
                "description" => $this->getTranslation('description', $lang),
                "tax" => $this->tax,
                "status" => $this->status,
                "is_featured" => $this->is_featured,
                "unit" => $this->unit->name,
                "selling_price" => $this->selling_price +  ($this->selling_price * $this->tax * .01),
                "min_order" => $this->min_order,
                "category" => new CategoryResource($this->whenLoaded('category')),
                'variation' => VariationResource::collection($this->variations),
                'is_favorite' => $user->favourites()->where('product_id', $this->id)->first() ? true : false,
                'is_cart' => $user->carts()->where('product_id', $this->id)->first() ? true : false,
                'cart_count' =>  $user->carts()->where('product_id', $this->id)->first() ? $user->carts()->where('product_id', $this->id)->first()->quantity : 0,
                //'productReviews' => ProductReviewResource::collection($this->productReviews),
                //'userProductReview' => $this->userProductReviews($user->id) ? $this->userProductReviews($user->id)->toArray() : null,
                'rating' => $this->rating,
                'total_rating' => $this->total_rating,
                'has_offer' => $this->offers()->first() ? true : false,
                'offer_id' => $this->offers()->first() ? $this->offers()->first()->id : 0,
                'offer_price' => $this->offers()->first() ? $this->offers()->first()->price : 0,
            ];
        }else{
            return[
                "id" => $this->id,
                "category_id" => $this->category_id,
                "name" => $this->getTranslation('name', $lang),
                "photo" => $this->productImages->first()->photo,
                "photos" => $this->productImages,
                "has_variation" => $this->has_variation,
                "attribute" => $this->attribute,
                "available_qty" => $this->available_quantity,
                "description" => $this->getTranslation('description', $lang),
                "tax" => $this->tax,
                "status" => $this->status,
                "is_featured" => $this->is_featured,
                "unit" => $this->unit->name,
                "selling_price" => $this->selling_price +  ($this->selling_price * $this->tax * .01),
                "min_order" => $this->min_order,
                "category" => new CategoryResource($this->whenLoaded('category')),
                'variation' => VariationResource::collection($this->variations),
                'rating' => $this->rating,
                'total_rating' => $this->total_rating,
                'has_offer' => $this->offers()->first() ? true : false,
                'offer_id' => $this->offers()->first() ? $this->offers()->first()->id : 0,
                'offer_price' => $this->offers()->first() ? $this->offers()->first()->price : 0,

                ];
            
        }
    }
}
