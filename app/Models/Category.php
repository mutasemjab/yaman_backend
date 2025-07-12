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

}
