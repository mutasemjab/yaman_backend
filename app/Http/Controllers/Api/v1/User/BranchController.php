<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
    {
        $branches = Branch::all();
        return response()->json(['data'=>$branches ]);
    }

    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {

    }


    public function edit($id)
    {


    }


    public function update(Request $request, $id)
    {


    }

    public function destroy(Request $request)
    {

    }

}
