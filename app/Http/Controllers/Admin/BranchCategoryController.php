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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'products' => 'array',
            'products.*' => 'exists:products,id'
        ]);

        DB::beginTransaction();
        
        try {
            // Add categories to branch
            foreach ($request->categories as $categoryId) {
                BranchCategory::updateOrCreate([
                    'branch_id' => $request->branch_id,
                    'category_id' => $categoryId
                ]);
            }
            
            // Add products to branch if provided
            if ($request->has('products')) {
                foreach ($request->products as $productId) {
                    BranchProduct::updateOrCreate([
                        'branch_id' => $request->branch_id,
                        'product_id' => $productId
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('branch-categories.index')
                           ->with('success', __('messages.created_successfully'));
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                           ->with('error', __('messages.error_occurred'))
                           ->withInput();
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = Branch::with(['categories', 'products'])->findOrFail($id);
        $allCategories = Category::all();
        $allProducts = Product::all();
        
        // Get currently assigned categories and products
        $assignedCategories = $branch->categories->pluck('id')->toArray();
        $assignedProducts = $branch->products->pluck('id')->toArray();
        
        return view('admin.branch-categories.edit', compact(
            'branch', 
            'allCategories', 
            'allProducts', 
            'assignedCategories', 
            'assignedProducts'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'products' => 'array',
            'products.*' => 'exists:products,id'
        ]);

        $branch = Branch::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Update categories
            if ($request->has('categories')) {
                // Remove existing categories
                BranchCategory::where('branch_id', $branch->id)->delete();
                
                // Add new categories
                foreach ($request->categories as $categoryId) {
                    BranchCategory::create([
                        'branch_id' => $branch->id,
                        'category_id' => $categoryId
                    ]);
                }
            }
            
            // Update products
            if ($request->has('products')) {
                // Remove existing products
                BranchProduct::where('branch_id', $branch->id)->delete();
                
                // Add new products
                foreach ($request->products as $productId) {
                    BranchProduct::create([
                        'branch_id' => $branch->id,
                        'product_id' => $productId
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('branch-categories.index')
                           ->with('success', __('messages.updated_successfully'));
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                           ->with('error', __('messages.error_occurred'))
                           ->withInput();
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

