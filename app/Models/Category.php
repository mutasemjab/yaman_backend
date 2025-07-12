<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $guarded=[];

   
   public function products()
   {
       return $this->hasMany(Product::class);
   }

     // Define the parent-child relationship
     public function parentCategory()
     {
         return $this->belongsTo(Category::class, 'category_id');
     }

     // Define the child categories relationship
     public function childCategories()
     {
         return $this->hasMany(Category::class, 'category_id');
     }

     public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_categories');
    }

    public function branchCategories()
    {
        return $this->hasMany(BranchCategory::class);
    }

    // Helper method to get name based on current locale
    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }
    
    // Scope to get categories for a specific branch
    public function scopeForBranch($query, $branchId)
    {
        return $query->whereHas('branches', function($q) use ($branchId) {
            $q->where('branches.id', $branchId);
        });
    }
}
