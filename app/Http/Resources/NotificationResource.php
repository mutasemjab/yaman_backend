<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => trans('admin.'.$this->title),
            'body' => $this->body,
            'day' => date('D',strtotime($this->created_at)),
            'date' => date('Y-m-d',strtotime($this->created_at)),
            'hour' => date('h:m a',strtotime($this->created_at)),
        ];
    }
}
