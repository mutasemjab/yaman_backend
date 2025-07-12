<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user =auth()->user();
        $lang= $user ? $user->locale : 'en';
         return [
            'id' => $this->id,
            'title' => $this->getTranslation('title',$lang),
            'description' => $this->getTranslation('description',$lang),
            'category_id' => $this->category_id,
            'image' => $this->image_url,
            'products' => ProductResource::collection($this->products)->additional(['lang' => $lang]),
        ];
    }
}
