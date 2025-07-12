<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{
    public function index($id)
    {
        $branchId = $id;
         if ($branchId) {
        $cats = Category::where('branch_id', $branchId)
                        ->with(['childCategories' => function($query) use ($branchId) {
                            $query->where('branch_id', $branchId);
                        }])
                        ->get();
        } else {
            $cats = Category::with('childCategories')->get();
        }
        
        return response()->json(['data' => $cats]);
    }


 /*   public function indexGuest(Request $request, $lang)
    {
        $cats = Category::with('childCategories')->get();
        return CategoryResource::collection($cats)->additional(['lang' => $lang]);
    }
*/

    public function create()
    {
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
    }


    public function update(Request $request)
    {
    }


    public function destroy($id)
    {
    }

    public function getProducts($id)
    {

        $products = Product::with('productImages','productReviews','variations','category')->where('category_id', $id)->get();
        return response()->json(['data'=>$products]);   
    }
}
