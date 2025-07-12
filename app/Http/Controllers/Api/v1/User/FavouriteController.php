<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\ProductResource;
use App\Models\Favorite;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $favorite = $user->favourites;
        return response()->json(['data'=>$favorite]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'product_id'=>'required|exists:products,id'
        ]);

        $favorite = Favourite::where('user_id',$request->user()->id)
            ->where('product_id',$request->product_id)->first();
        if($favorite){
            if ($favorite->delete()) {
                return response(['message' => 'Changed','is_favorite'=>false], 200);
            }else{
                return response(['errors' => ['Something wrong']], 403);
            }
        }
        $favorite = new Favourite();
        $favorite->user_id = $request->user()->id;
        $favorite->product_id = $request->product_id;
        if ($favorite->save()) {
            return response(['message' => 'Changed','is_favorite'=>true], 200);
        }else{
            return response(['errors' => ['Something wrong']], 403);
        }
    }

}
