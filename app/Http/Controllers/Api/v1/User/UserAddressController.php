<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAddressController extends Controller
{
    public function index(Request $request)
    {

        $user_id = $request->user()->id;
        $address = Address::with('delivery')->where('user_id', $user_id)->get();
         return  response()->json(['data'=>$address]);
  
    }

    public function create()
    {
    }


    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $this->validate($request, [
            'longitude' => 'required',
            'latitude' => 'required',
            'address' => 'required',
            'building_number' => 'required',

        ]);

        DB::beginTransaction();
        try {
            if ($address = Address::where('user_id', $user_id)->where(function ($query) use ($request) {
                $query->where('longitude', $request->longitude)
                    ->where('latitude', $request->latitude);
            })->first()) {
            } else {
                $address = new Address();
            }
            $address->longitude = $request->longitude;
            $address->latitude = $request->latitude;
            $address->address = $request->address;
            $address->building_number = $request->building_number;
            $address->user_id = $user_id;
            $address->delivery_id = $request->delivery_id;
            $address->save();
            DB::commit();
            return response(['message' => 'Address added'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response(['errors' => ['Something wrong']], 403);
        }
    }

    public function show($id)
    {
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $address_id)
    {

        $userAddress = Address::findOrFail($address_id);
        $userAddress->longitude = $request->longitude ?? $userAddress->longitude;
        $userAddress->latitude = $request->latitude ?? $userAddress->latitude;
        $userAddress->address = $request->address ?? $userAddress->address;
        $userAddress->building_number = $request->building_number ?? $userAddress->building_number;
        $userAddress->delivery_id = $request->delivery_id ?? $userAddress->delivery_id;

        if ($userAddress->save()) {
            return response(['message' => ['Your address has been changed']]);
        } else {
            return response(['errors' => ['There is something wrong']], 402);
        }
    }


    public function destroy($id)
    {

        $userAddress = Address::find($id);
        if ($userAddress->delete()) {
            return response(['message' => 'Address is deleted'], 200);
        } else {
            return response(['errors' => ['Something wrong']], 403);
        }
    }
}
