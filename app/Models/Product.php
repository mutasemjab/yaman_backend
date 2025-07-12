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

     public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products');
    }

    public function branchProducts()
    {
        return $this->hasMany(BranchProduct::class);
    }

    // Helper method to get name based on current locale
    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    // Helper method to get description based on current locale
    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }
}
