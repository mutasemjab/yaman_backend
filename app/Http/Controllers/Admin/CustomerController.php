<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

use App\Models\Children;
use App\Models\Delivery;
use App\Models\Wallet;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->search) {
            $data = User::where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`, `phone`)'), 'like', '%' . $request->search . '%');
            })->paginate(PAGINATION_COUNT);
        } else {
            $data = User::paginate(PAGINATION_COUNT);
        }

        $searchQuery = $request->search;

        return view('admin.customers.index', compact('data', 'searchQuery'));
    }

    public function create()
    {
       return view('admin.customers.create');
    }

    public function export(Request $request)
    {
        return Excel::download(new UsersExport($request->search), 'users.xlsx');
    }

    public function store(Request $request)
    {
      try{
          $customer = new User();
          $customer->name = $request->get('name');
          $customer->email = $request->get('email');
          $customer->phone = $request->get('phone');

           if($request->activate){
              $customer->activate = $request->get('activate');
          }

          if ($request->has('photo')) {
            $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
            $customer->photo = $the_file_path;
         }
          if($customer->save()){
              return redirect()->route('admin.customer.index')->with(['success' => 'Customer created']);

          }else{
              return redirect()->back()->with(['error' => 'Something wrong']);
          }

      }catch(\Exception $ex){
          return redirect()->back()
          ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
          ->withInput();
      }

    }


    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.customers.show',compact('data','children',));
    }


    public function edit($id)
    {
        if (auth()->user()->can('customer-edit')) {
            $data = User::findorFail($id);
            return view('admin.customers.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

       public function update(Request $request,$id)
       {
         $customer=User::findorFail($id);
         try{

             $customer->name = $request->get('name');

             $customer->email = $request->get('email');
             $customer->phone = $request->get('phone');
            
             if($request->activate){
                $customer->activate = $request->get('activate');
            }
            if ($request->has('photo')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $customer->photo = $the_file_path;
             }
             if($customer->save()){
                 return redirect()->route('admin.customer.index')->with(['success' => 'Customer update']);

             }else{
                 return redirect()->back()->with(['error' => 'Something wrong']);
             }

         }catch(\Exception $ex){
             return redirect()->back()
             ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
             ->withInput();
         }

      }

     //  public function delete($id)
    //     {
    //         try {

    //             $item_row = User::select("name")->where('id','=',$id)->first();

    //             if (!empty($item_row)) {

    //         $flag = User::where('id','=',$id)->delete();;

    //         if ($flag) {
    //             return redirect()->back()
    //             ->with(['success' => '   Delete Succefully   ']);
    //             } else {
    //             return redirect()->back()
    //             ->with(['error' => '   Something Wrong']);
    //             }

    //             } else {
    //             return redirect()->back()
    //             ->with(['error' => '   cant reach fo this data   ']);
    //             }

    //       } catch (\Exception $ex) {

    //             return redirect()->back()
    //             ->with(['error' => ' Something Wrong   ' . $ex->getMessage()]);
    //             }
    //     }


    //   public function ajax_search(Request $request)
    //   {
    //       if ($request->ajax()) {


    //       $search_by_text = $request->search_by_text;
    //       $searchbyradio = $request->searchbyradio;

    //       if ($search_by_text != '') {
    //       if ($searchbyradio == 'customer_code') {
    //       $field1 = "customer_code";
    //       $operator1 = "=";
    //       $value1 = $search_by_text;
    //       } elseif ($searchbyradio == 'account_number') {
    //       $field1 = "account_number";
    //       $operator1 = "=";
    //       $value1 = $search_by_text;
    //       } else {
    //       $field1 = "name";
    //       $operator1 = "like";
    //       $value1 = "%{$search_by_text}%";
    //       }
    //       } else {
    //       //true
    //       $field1 = "id";
    //       $operator1 = ">";
    //       $value1 = 0;
    //       }


    //       $data = User::where($field1, $operator1, $value1)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

    //       return view('admin.customers.ajax_search', ['data' => $data]);
    //       }
    //       }



}
