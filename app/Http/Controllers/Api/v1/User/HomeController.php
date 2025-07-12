<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\OtherPageResource;
use App\Models\OtherPage;

class HomeController extends Controller
{
    public function privecy_police()
    {
        $itemlist = OtherPage::where('slug','privacy-policy')->first();
        $itemlist = new OtherPageResource($itemlist);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $itemlist], 200);

    }
    public function about_us()
    {
        $itemlist = OtherPage::where('slug','about-us')->first();

        $itemlist = new OtherPageResource($itemlist);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $itemlist], 200);

    }

    public function terms_and_conditions()
    {
        $itemlist = OtherPage::where('slug','terms-and-conditions')->first();
        $itemlist = new OtherPageResource($itemlist);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $itemlist], 200);

    }


}
