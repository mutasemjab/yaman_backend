<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;


class OrderController extends Controller
{
      public function index(){

       $user_id = auth()->user()->id;

        $order = Order::with('address','products','products.productImages')->where('user_id',$user_id )->get();

        return response()->json(['data'=>$order]);
      }



      public function store(Request $request)
      {
          // Validate the request data
          $user_id = auth()->user()->id;

          $request->validate([
              'payment_type' => 'required|string',
              'address_id' => 'required',
          ]);

          // Find all the cart items with status 0 for the current user
          $cartItems = Cart::where('user_id', $user_id)->where('status', 0)->get();

          // Calculate the total_discounts, delivery_fee, total_taxes, and total_prices
          $total_discounts = 0;
          $delivery_fee = 0;
          $total_taxes = 0;
          $total_prices = 0;
          $totalPriceBeforeTaxSum =0;

          $address = Address::with('delivery')->where('id',$request->input('address_id'))->first();
          $delivery_fee = $address->delivery->price ?? 0;

          foreach ($cartItems as $cartItem) {
              $total_discounts = $cartItem->discount_coupon ?? 0;
              $total_taxes =  $cartItem->product->tax ?? 0;
              // You might need to adjust the calculations based on your business logic
              $total_prices += $cartItem->total_price_product;
          }

          // Create a new order
          $order = new Order([
              'address_id' => $request->input('address_id'),
              'payment_type' => $request->input('payment_type'),
              'total_discounts' => $total_discounts,
              'delivery_fee' => $delivery_fee, // You can adjust this value as needed
              'total_taxes' => $total_taxes, // You can adjust this value as needed
              'total_prices' => $total_prices,
              'date' => now(),
              'user_id' => auth()->id(),
          ]);
          $order->save();

           foreach($cartItems as $cartItem){
            $total_price_after_tax_for_result = $cartItem->price * $cartItem->quantity;
            $total_price_before_tax_for_result =  $total_price_after_tax_for_result / (1 + ($cartItem->product->tax / 100));
            $totalPriceBeforeTaxSum += $total_price_before_tax_for_result;
           }

           $final_result_total_price_before_tax =  $totalPriceBeforeTaxSum;

           $discount_percentage = $cartItem->discount_coupon / $final_result_total_price_before_tax;

          foreach ($cartItems as $cartItem) {
            $total_price_after_tax = $cartItem->price * $cartItem->quantity;
            $total_price_before_tax =  $total_price_after_tax / (1 + ($cartItem->product->tax / 100));
            // Attach detailed product data to the order
            $order->products()->attach($cartItem->product_id, [
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'variation_id' => $cartItem->variation_id,
                'total_price_after_tax' => $total_price_after_tax,
                'total_price_before_tax' => $total_price_before_tax,
                'tax_percentage' => $cartItem->product->tax,
                'discount_percentage' => $discount_percentage, // Set initial value
                'discount_value' => $discount_percentage * $total_price_before_tax, // Set initial value
                'tax_value' => ($total_price_before_tax - ($discount_percentage * $total_price_before_tax)) * ($cartItem->product->tax / 100) ,
            ]);
        }


          // Update the cart status to 1
          Cart::where('user_id', $user_id)->where('status', 0)->update([
              'status' => 1,
          ]);

          return response()->json($order, 200);
      }


      public function cancel_order($id)
      {
          // Find the order by ID
          $order = Order::find($id);

          // Check if the order exists
          if (!$order) {
              return response()->json(['message' => 'Order not found'], 404);
          }

          // Check if the order is cancellable (you may need to add additional logic here)
          if ($order->status == 1 ) {
              // Update the order status to cancelled
              $order->update(['status' => 3]);


              return response()->json(['message' => 'Order cancelled successfully'], 200);
          } else {
              return response()->json(['message' => 'Order is already cancelled'], 422);
          }
      }


}
