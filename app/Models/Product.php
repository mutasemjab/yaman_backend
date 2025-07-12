<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class,);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class)->whereDate('expired_at', '>', now());
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('variation_id','quantity','unit_price','total_price_after_tax','tax_percentage','tax_value','total_price_before_tax','discount_percentage','discount_value');
    }
}
