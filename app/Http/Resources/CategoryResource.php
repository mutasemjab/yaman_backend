<?php

namespace App\Http\Resources;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\Manager;
use App\Models\Admin;
use App\Models\SubCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;


class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->lang ? $request->lang : 'en';
        if (!$lang) {
            $lang = auth()->user() ? auth()->user()->locale: 'en';
        }
        $available = true;

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $lang),
            'description' => $this->getTranslation('description', $lang),
            'photo' => $this->photo,
        ];
    }
}
