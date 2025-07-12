<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Models\Manager;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $itemlist = Product::with('category', 'variations', 'productImages');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $itemlist->where(function ($query) use ($search) {
                $query->where('name_en', 'LIKE', "%$search%")
                    ->orWhere('name_ar', 'LIKE', "%$search%")
                    ->orWhere('description_en', 'LIKE', "%$search%")
                    ->orWhere('description_ar', 'LIKE', "%$search%");
            });
        }

        // Sorting by price
        if ($request->has('sort')) {
            $sortOrder = $request->sort == 'asc' ? 'asc' : 'desc';
            $itemlist = $itemlist->orderBy('selling_price', $sortOrder);
        }

        // Filtering by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
            $itemlist = $itemlist->whereBetween('selling_price', [$minPrice, $maxPrice]);
        }

        $itemlist = $itemlist->get();


        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $itemlist], 200);
    }


    public function productDetails($id)
    {
        $user = auth()->user();

        $item = Product::with('category', 'variations', 'productImages')
            ->where('id', $id)->get();
        return response()->json(['data' => $item], 200);
    }
    public function latest()
    {

        // $shop_cat = ShopCategory::whereIn('shop_id',$shop_ids)->pluck('category_id')->toArray();
        $itemlist = Product::with('category', 'variations', 'productImages')->where('status', 1)->where('is_featured', 1)->get();
        return response()->json(['data' => $itemlist], 200);
    }



    public function offers()
    {

        $item = Product::with('category', 'variations', 'productImages')
            ->orderBy('id', 'DESC')->where('status', 1)->whereHas('offers')->get();
        return response()->json(['data' => $item], 200);
    }
}
