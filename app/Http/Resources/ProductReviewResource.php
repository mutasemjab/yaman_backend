<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
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
            'id' => $this->id,
            'user_name' => User::findOrFail($this->user_id)->name,
            'user_image' => User::findOrFail($this->user_id)->photo,
            'review' => $this->review,
            'rating' => $this->rating,
        ];
    }
}
