<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Category::paginate(PAGINATION_COUNT);

        return view('admin.categories.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $category = new Category();

            $category->name_en = $request->get('name_en');
            $category->name_ar = $request->get('name_ar');

            $parentCategoryID = $request->input('category_id');
            if ($parentCategoryID) {
                // Attach the parent category
                $parentCategory = Category::find($parentCategoryID);
                if ($parentCategory) {
                    $category->parentCategory()->associate($parentCategory);
                } else {
                    // Handle the case where the specified parent category does not exist
                    return redirect()->route('categories.index')->with('error', 'Parent category not found.');
                }
            }

            if ($request->has('photo')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $category->photo = $the_file_path;
             }

            if($category->save()){
                return redirect()->route('categories.index')->with(['success' => 'Category created']);

            }else{
                return redirect()->back()->with(['error' => 'Something wrong']);
            }

        }catch(\Exception $ex){
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
        $data = Category::findOrFail($id); // Retrieve the category by ID
        $categories = Category::all();
        return view('admin.categories.edit', ['categories' => $categories,'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);


            $category->name_en = $request->get('name_en');
            $category->name_ar = $request->get('name_ar');


            $parentCategoryID = $request->input('category_id');
            if ($parentCategoryID) {
                // Attach the parent category
                $parentCategory = Category::find($parentCategoryID);
                if ($parentCategory) {
                    $category->parentCategory()->associate($parentCategory);
                } else {
                    // Handle the case where the specified parent category does not exist
                    return redirect()->route('categories.index')->with('error', 'Parent category not found.');
                }
            } else {
                // If no parent category is specified, disassociate from any existing parent
                $category->parentCategory()->dissociate();
            }

            if ($request->hasFile('photo')) {
                // Upload and store the new photo
                $photoPath = uploadImage('assets/admin/uploads', $request->file('photo'));
                $category->photo = $photoPath;
            }

            if ($category->save()) {
                return redirect()->route('categories.index')->with(['success' => 'Category updated']);
            } else {
                return redirect()->back()->with(['error' => 'Something went wrong']);
            }
        } catch (\Exception $ex) {
            // Log the exception for debugging purposes
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

            $item_row = Category::select("name")->where('id','=',$id)->first();

            if (!empty($item_row)) {

        $flag = Category::where('id','=',$id)->delete();

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

