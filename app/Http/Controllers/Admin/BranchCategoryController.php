<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\BranchCategory;
use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BranchCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::with(['categories.products', 'products.category'])->get();
        
        // Get branch categories with their products
        $branchData = [];
        foreach ($branches as $branch) {
            $branchData[$branch->id] = [
                'branch' => $branch,
                'categories' => $branch->categories()->with('products')->get(),
                'total_products' => $branch->products()->count()
            ];
        }
        
        return view('admin.branch-categories.index', compact('branchData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $categories = Category::all();
        $products = Product::all();
        
        return view('admin.branch-categories.create', compact('branches', 'categories', 'products'));
    }

    

    public function store(Request $request)
    {
        // Debug: Log all incoming data
        \Log::info('Form submission data:', [
            'all_data' => $request->all(),
            'categories' => $request->get('categories'),
            'products' => $request->get('products'),
            'category_order' => $request->get('category_order'),
            'product_order' => $request->get('product_order'),
        ]);

        // Simplified validation first
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        DB::beginTransaction();

        try {
            $branchId = $request->branch_id;
            $categories = $request->categories;
            $products = $request->products ?? [];
            $categoryOrder = $request->category_order ?? [];
            $productOrder = $request->product_order ?? [];

            // Debug: Log processed data
            \Log::info('Processed data:', [
                'branch_id' => $branchId,
                'categories' => $categories,
                'products' => $products,
                'category_order' => $categoryOrder,
                'product_order' => $productOrder,
            ]);

            // Clear existing assignments
            DB::table('branch_categories')->where('branch_id', $branchId)->delete();
            DB::table('branch_products')->where('branch_id', $branchId)->delete();

            // Insert categories with order
            foreach ($categories as $categoryId) {
                $order = isset($categoryOrder[$categoryId]) ? (int)$categoryOrder[$categoryId] : 0;
                
                \Log::info("Inserting category {$categoryId} with order {$order}");
                
                DB::table('branch_categories')->insert([
                    'branch_id' => $branchId,
                    'category_id' => $categoryId,
                    'order' => $order,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert products with order and category association
            foreach ($products as $productId) {
                $product = Product::find($productId);
                if ($product) {
                    $order = isset($productOrder[$productId]) ? (int)$productOrder[$productId] : 0;
                    
                    \Log::info("Inserting product {$productId} with order {$order}");
                    
                    DB::table('branch_products')->insert([
                        'branch_id' => $branchId,
                        'product_id' => $productId,
                        'category_id' => $product->category_id,
                        'order' => $order,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('branch-categories.index')
                ->with('success', __('messages.Categories and products assigned successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in store method:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    /**
     * Get ordered categories for a branch
     */
    public function getOrderedCategories($branchId)
    {
        return DB::table('branch_categories')
            ->join('categories', 'branch_categories.category_id', '=', 'categories.id')
            ->where('branch_categories.branch_id', $branchId)
            ->orderBy('branch_categories.order')
            ->select('categories.*', 'branch_categories.order')
            ->get();
    }

    /**
     * Get ordered products for a branch and category
     */
    public function getOrderedProducts($branchId, $categoryId = null)
    {
        $query = DB::table('branch_products')
            ->join('products', 'branch_products.product_id', '=', 'products.id')
            ->where('branch_products.branch_id', $branchId);

        if ($categoryId) {
            $query->where('branch_products.category_id', $categoryId);
        }

        return $query->orderBy('branch_products.order')
            ->select('products.*', 'branch_products.order', 'branch_products.category_id')
            ->get();
    }

    /**
     * Update category order via AJAX
     */
    public function updateCategoryOrder(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_orders' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->category_orders as $categoryId => $order) {
                DB::table('branch_categories')
                    ->where('branch_id', $request->branch_id)
                    ->where('category_id', $categoryId)
                    ->update(['order' => $order]);
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update product order via AJAX
     */
    public function updateProductOrder(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_orders' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->product_orders as $productId => $order) {
                DB::table('branch_products')
                    ->where('branch_id', $request->branch_id)
                    ->where('product_id', $productId)
                    ->update(['order' => $order]);
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with(['categories.products', 'products.category'])->findOrFail($id);
        
        // Get categories assigned to this branch
        $branchCategories = $branch->categories()->with('products')->get();
        
        // Get products assigned to this branch grouped by category
        $branchProducts = $branch->products()->with('category')->get()->groupBy('category_id');
        
        return view('admin.branch-categories.show', compact('branch', 'branchCategories', 'branchProducts'));
    }

    public function edit($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $allCategories = Category::with('products')->orderBy('name_en')->get();
        $allProducts = Product::with('category')->get();
        
        // Get assigned categories with their order
        $assignedCategoriesData = DB::table('branch_categories')
            ->where('branch_id', $branchId)
            ->orderBy('order')
            ->get();
        
        $assignedCategories = $assignedCategoriesData->pluck('category_id')->toArray();
        $categoryOrders = $assignedCategoriesData->pluck('order', 'category_id')->toArray();
        
        // Get assigned products with their order
        $assignedProductsData = DB::table('branch_products')
            ->where('branch_id', $branchId)
            ->orderBy('order')
            ->get();
        
        $assignedProducts = $assignedProductsData->pluck('product_id')->toArray();
        $productOrders = $assignedProductsData->pluck('order', 'product_id')->toArray();
        
        return view('admin.branch-categories.edit', compact(
            'branch',
            'allCategories',
            'allProducts',
            'assignedCategories',
            'assignedProducts',
            'categoryOrders',
            'productOrders'
        ));
    }
   

    public function update(Request $request, $branchId)
    {
        $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'products' => 'nullable|array',  // Changed to nullable
            'products.*' => 'exists:products,id',
            'category_order' => 'nullable|array',  // Changed to nullable
            'category_order.*' => 'integer|min:0',  // Changed min to 0
            'product_order' => 'nullable|array',   // Changed to nullable
            'product_order.*' => 'integer|min:0',   // Changed min to 0
        ]);

        DB::beginTransaction();

        try {
            $categories = $request->categories;
            $products = $request->products ?? [];
            $categoryOrder = $request->category_order ?? [];
            $productOrder = $request->product_order ?? [];

            // Clear existing assignments
            DB::table('branch_categories')->where('branch_id', $branchId)->delete();
            DB::table('branch_products')->where('branch_id', $branchId)->delete();

            // Insert categories with order
            foreach ($categories as $categoryId) {
                DB::table('branch_categories')->insert([
                    'branch_id' => $branchId,
                    'category_id' => $categoryId,
                    'order' => $categoryOrder[$categoryId] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert products with order and category association
            foreach ($products as $productId) {
                $product = Product::find($productId);
                if ($product) {
                    DB::table('branch_products')->insert([
                        'branch_id' => $branchId,
                        'product_id' => $productId,
                        'category_id' => $product->category_id,
                        'order' => $productOrder[$productId] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('branch-categories.index')
                ->with('success', __('messages.Branch categories updated successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', __('messages.Error occurred while updating'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $branch = Branch::findOrFail($id);
            
            // Remove all categories and products assigned to this branch
            BranchCategory::where('branch_id', $branch->id)->delete();
            BranchProduct::where('branch_id', $branch->id)->delete();
            
            return redirect()->route('branch-categories.index')
                           ->with('success', __('messages.assignments_removed'));
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', __('messages.error_occurred'));
        }
    }
    
    /**
     * Get products by category for AJAX
     */
    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->category_id;
        $products = Product::where('category_id', $categoryId)->get();
        
        return response()->json($products);
    }
    
    /**
     * Remove specific category from branch
     */
    public function removeCategory(Request $request)
    {
        $branchId = $request->branch_id;
        $categoryId = $request->category_id;
        
        BranchCategory::where('branch_id', $branchId)
                     ->where('category_id', $categoryId)
                     ->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Remove specific product from branch
     */
    public function removeProduct(Request $request)
    {
        $branchId = $request->branch_id;
        $productId = $request->product_id;
        
        BranchProduct::where('branch_id', $branchId)
                     ->where('product_id', $productId)
                     ->delete();
        
        return response()->json(['success' => true]);
    }
}

