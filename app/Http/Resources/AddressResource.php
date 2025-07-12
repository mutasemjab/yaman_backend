<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->lang;
        return [
            'id' => $this->id,
            'longitude' => $this->longitude,
            'latitude'=>$this->latitude,
            'address' => $this->address ,
            'street' => $this->street ,
            'building_number' => $this->building_number ,
            'default' => $this->default ,
            'user_id' => $this->user_id ,
            'delivery_id' => $this->delivery_id ,
            'delivery_price' => $this->delivery->price ,
            'created_at' => $this->created_at ,
            'updated_at' => $this->updated_at,
        ];
    }
}
