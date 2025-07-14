<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;
use App\Models\BranchCategory;
use App\Models\BranchProduct;


class CategoryController extends Controller
{
    /**
     * Get categories for a specific branch ordered by their order column
     * 
     * @param int $id Branch ID
     * @return \Illuminate\Http\JsonResponse
     */
     public function index($id)
    {
        $branchId = $id;
        
        if ($branchId) {
            // First, verify the branch exists
            $branch = Branch::find($branchId);
            
            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.Branch not found'),
                    'data' => []
                ], 404);
            }
            
            // Get categories assigned to this branch ordered by the order column
            $cats = Category::join('branch_categories', 'categories.id', '=', 'branch_categories.category_id')
                    ->where('branch_categories.branch_id', $branchId)
                    ->orderBy('branch_categories.order', 'asc')
                    ->orderBy('categories.name_en', 'asc') // Secondary sort by name
                    ->select('categories.*', 'branch_categories.order as branch_order')
                    ->get();
            
            // If no categories found for this branch, return empty array
            if ($cats->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => __('messages.No categories assigned to this branch'),
                    'data' => []
                ]);
            }
            
        } else {
            // Get all categories if no branch specified (fallback)
            $cats = Category::orderBy('name_en')->get();
        }
        
        // Transform data to include localized names and order
        $transformedCats = $cats->map(function($category) {
            return [
                'id' => $category->id,
                'name' => app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en,
                'name_en' => $category->name_en,
                'name_ar' => $category->name_ar,
                'photo' => $category->photo,
                'order' => $category->branch_order ?? 0, // Include order from branch_categories
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $transformedCats
        ]);
    }

    /**
     * Get products for a specific category within a specific branch ordered by their order column
     * 
     * @param int $categoryId Category ID
     * @param int|null $branchId Branch ID (optional, can be passed as query parameter)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts($categoryId, Request $request)
    {
        $branchId = $request->query('branch_id');
        
        if ($branchId) {
            // Get products that belong to both the category and the branch, ordered by branch_products.order
            $products = Product::with(['productImages', 'productReviews', 'variations', 'category'])
                             ->join('branch_products', 'products.id', '=', 'branch_products.product_id')
                             ->where('products.category_id', $categoryId)
                             ->where('branch_products.branch_id', $branchId)
                             ->where('products.status', 1) // Only active products
                             ->orderBy('branch_products.order', 'asc')
                             ->orderBy('products.name_en', 'asc') // Secondary sort by name
                             ->select('products.*', 'branch_products.order as branch_order')
                             ->get();
        } else {
            // Fallback: Get all products in category (original behavior)
            $products = Product::with(['productImages', 'productReviews', 'variations', 'category'])
                             ->where('category_id', $categoryId)
                             ->where('status', 1)
                             ->orderBy('name_en')
                             ->get();
        }
        
        if ($products->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => $branchId 
                    ? __('messages.No products found in this category for this branch')
                    : __('messages.No products found in this category'),
                'data' => []
            ]);
        }
        
        // Transform products to include localized data and order
        $transformedProducts = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en,
                'name_en' => $product->name_en,
                'name_ar' => $product->name_ar,
                'description' => app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en,
                'description_en' => $product->description_en,
                'description_ar' => $product->description_ar,
                'selling_price' => $product->selling_price,
                'tax' => $product->tax,
                'rating' => $product->rating,
                'total_rating' => $product->total_rating,
                'min_order' => $product->min_order,
                'available_quantity' => $product->available_quantity,
                'has_variation' => $product->has_variation,
                'is_featured' => $product->is_featured,
                'is_favourite' => $product->is_favourite,
                'status' => $product->status,
                'attribute' => $product->attribute,
                'category_id' => $product->category_id,
                'unit_id' => $product->unit_id,
                'order' => $product->branch_order ?? 0, // Include order from branch_products
                'category' => [
                    'id' => $product->category->id,
                    'name' => app()->getLocale() === 'ar' ? $product->category->name_ar : $product->category->name_en,
                    'name_en' => $product->category->name_en,
                    'name_ar' => $product->category->name_ar,
                ],
                'product_images' => $product->productImages,
                'product_reviews' => $product->productReviews,
                'variations' => $product->variations,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $transformedProducts
        ]);
    }

    /**
     * Get category with its products ordered by their respective order columns
     */
     public function getCategoryWithProducts($categoryId, $branchId)
    {
        // Check if category is assigned to this branch and get its order
        $branchCategory = BranchCategory::where('branch_id', $branchId)
                                       ->where('category_id', $categoryId)
                                       ->first();
        
        if (!$branchCategory) {
            return response()->json([
                'success' => false,
                'message' => __('messages.Category not assigned to this branch'),
                'data' => []
            ], 404);
        }
        
        $category = Category::find($categoryId);
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => __('messages.Category not found'),
                'data' => []
            ], 404);
        }
        
        // Get products for this category in this branch, ordered by branch_products.order
        $products = Product::with(['productImages', 'productReviews', 'variations'])
                          ->join('branch_products', 'products.id', '=', 'branch_products.product_id')
                          ->where('products.category_id', $categoryId)
                          ->where('branch_products.branch_id', $branchId)
                          ->where('products.status', 1)
                          ->orderBy('branch_products.order', 'asc')
                          ->orderBy('products.name_en', 'asc')
                          ->select('products.*', 'branch_products.order as branch_order')
                          ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'name' => app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en,
                    'name_en' => $category->name_en,
                    'name_ar' => $category->name_ar,
                    'photo' => $category->photo,
                    'order' => $branchCategory->order,
                ],
                'products' => $products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en,
                        'name_en' => $product->name_en,
                        'name_ar' => $product->name_ar,
                        'description' => app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en,
                        'description_en' => $product->description_en,
                        'description_ar' => $product->description_ar,
                        'selling_price' => $product->selling_price,
                        'tax' => $product->tax,
                        'rating' => $product->rating,
                        'total_rating' => $product->total_rating,
                        'min_order' => $product->min_order,
                        'available_quantity' => $product->available_quantity,
                        'has_variation' => $product->has_variation,
                        'is_featured' => $product->is_featured,
                        'is_favourite' => $product->is_favourite,
                        'status' => $product->status,
                        'attribute' => $product->attribute,
                        'category_id' => $product->category_id,
                        'unit_id' => $product->unit_id,
                        'order' => $product->branch_order,
                        'product_images' => $product->productImages,
                        'product_reviews' => $product->productReviews,
                        'variations' => $product->variations,
                    ];
                })
            ]
        ]);
    }
}
