<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all orders for the authenticated user
      $data = Order::paginate(PAGINATION_COUNT);

       return view('admin.orders.index', compact('data'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('products', 'products.variations')->findOrFail($id);
        return view('admin.orders.show', compact('order'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the order by ID for the authenticated user
        $data = Order::findOrFail($id);

        return view('admin.orders.edit', compact('data'));
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

        // Find the order by ID for the authenticated user
        $order = Order::findOrFail($id);

        // Update the order details
        $order->order_status = $request->input('order_status');
        $order->payment_status = $request->input('payment_status');

        if($order->save()){
            return redirect()->route('orders.index')->with(['success' => 'Order Updated']);

        }else{
            return redirect()->back()->with(['error' => 'Something wrong']);
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
        //
    }
}
