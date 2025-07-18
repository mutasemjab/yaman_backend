<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function order()
    {
        return $this->hasMany(Order::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
        public function delivery()
    {
       return $this->belongsTo(Delivery::class);
    }


}
