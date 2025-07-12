<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    
     protected $guarded=[];

      public function categories()
    {
        return $this->belongsToMany(Category::class, 'branch_categories');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_products');
    }

    public function branchCategories()
    {
        return $this->hasMany(BranchCategory::class);
    }

    public function branchProducts()
    {
        return $this->hasMany(BranchProduct::class);
    }
}
