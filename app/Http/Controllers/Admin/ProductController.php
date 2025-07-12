<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Product::paginate(PAGINATION_COUNT);

        return view('admin.products.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $units = Unit::get();
        return view('admin.products.create',compact('categories','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Create a new product without saving it to the database yet
            $product = new Product();

            $product->name_en = $request->input('name_en');
            $product->name_ar = $request->input('name_ar');
            $product->description_en = $request->input('description_en');
            $product->description_ar = $request->input('description_ar');
            $product->available_quantity = $request->input('available_quantity');
            $product->has_variation = $request->input('has_variation');
            $product->tax = $request->input('tax');
            $product->selling_price = $request->input('selling_price');
            $product->rating = $request->input('rating');
            $product->total_rating = $request->input('total_rating');
            $product->min_order = $request->input('min_order');
            $product->status = $request->input('status');
            $product->is_featured = $request->input('is_featured');

            $product->category_id = $request->input('category');
            $product->unit_id = $request->input('unit');

            if ($product->has_variation) {
                $product->save(); // Save the product first to generate an ID

                $variations = $request->input('variations');
                $quantities = $request->input('available_quantities');
                $attributes = $request->input('attributes');

                foreach ($variations as $key => $variation) {
                    $product->variations()->create([
                        'variation' => $variation,
                        'available_quantity' => $quantities[$key],
                        'attributes' => $attributes[$key],
                    ]);
                }


                if ($request->hasFile('photo')) {
                    $photos = $request->file('photo');
                    foreach ($photos as $photo) {
                        $photoPath = uploadImage('assets/admin/uploads', $photo); // Use the uploadImage function
                        if ($photoPath) {
                            // Create a record in the product_images table for each image using the relationship
                            $productImage = new ProductImage();
                            $productImage->photo = $photoPath;

                            $product->productImages()->save($productImage); // Associate the image with the product
                        }
                    }
                }

            } else {
                $product->save(); // Save the product without variations

                if ($request->hasFile('photo')) {
                    $photos = $request->file('photo');
                    foreach ($photos as $photo) {
                        $photoPath = uploadImage('assets/admin/uploads', $photo); // Use the uploadImage function
                        if ($photoPath) {
                            // Create a record in the product_images table for each image using the relationship
                            $productImage = new ProductImage();
                            $productImage->photo = $photoPath;

                            $product->productImages()->save($productImage); // Associate the image with the product
                        }
                    }
                }
            }

            return redirect()->route('products.index')->with(['success' => 'Product created']);
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()
                ->with(['error' => 'An error occurred: ' . $ex->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id); // Retrieve the category by ID
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.products.edit', ['units' => $units,'categories' => $categories,'data' => $data]);
    }

         public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
    
            $product->name_en = $request->input('name_en');
            $product->name_ar = $request->input('name_ar');
            $product->description_en = $request->input('description_en');
            $product->description_ar = $request->input('description_ar');
            $product->available_quantity = $request->input('available_quantity');
            $product->has_variation = $request->input('has_variation');
            $product->tax = $request->input('tax');
            $product->selling_price = $request->input('selling_price');
            $product->rating = $request->input('rating');
            $product->total_rating = $request->input('total_rating');
            $product->min_order = $request->input('min_order');
            $product->status = $request->input('status');
            $product->is_featured = $request->input('is_featured');
            $product->category_id = $request->input('category');
            $product->unit_id = $request->input('unit');
    
            $product->save();
    
            // Remove existing variations if any
            $product->variations()->delete();
    
            if ($product->has_variation) {
                $variations = $request->input('variations');
                $quantities = $request->input('available_quantities');
                $attributes = $request->input('attributes');
    
                foreach ($variations as $key => $variation) {
                    $product->variations()->create([
                        'variation' => $variation,
                        'available_quantity' => $quantities[$key],
                        'attributes' => $attributes[$key],
                    ]);
                }
            }
    
            // Remove existing images if needed (optional: keep old images if required)
                      if ($request->hasFile('photo')) {
                // Delete old image files and DB records
                foreach ($product->productImages as $image) {
                    if (file_exists(public_path($image->photo))) {
                        unlink(public_path($image->photo));
                    }
                    $image->delete(); // Delete from DB
                }
            
                // Upload and insert new images
                foreach ($request->file('photo') as $photo) {
                    $photoPath = uploadImage('assets/admin/uploads', $photo);
                    if ($photoPath) {
                        $product->productImages()->create([
                            'photo' => $photoPath,
                        ]);
                    }
                }
            }


    
            return redirect()->route('products.index')->with(['success' => 'Product updated']);
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()
                ->with(['error' => 'An error occurred: ' . $ex->getMessage()])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try {

            $item_row = Product::select("name")->where('id','=',$id)->first();

            if (!empty($item_row)) {

        $flag = Product::where('id','=',$id)->delete();

        if ($flag) {
            return redirect()->back()
            ->with(['success' => '   Delete Succefully   ']);
            } else {
            return redirect()->back()
            ->with(['error' => '   Something Wrong']);
            }

            } else {
            return redirect()->back()
            ->with(['error' => '   cant reach fo this data   ']);
            }

       } catch (\Exception $ex) {

            return redirect()->back()
            ->with(['error' => ' Something Wrong   ' . $ex->getMessage()]);
            }
    }
}
