<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('variation_id','quantity','unit_price','total_price_after_tax','tax_percentage','tax_value','total_price_before_tax','discount_percentage','discount_value'); // You can store the quantity of each product in the pivot table
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }



}
