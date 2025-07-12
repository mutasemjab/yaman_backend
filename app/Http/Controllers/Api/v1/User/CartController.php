<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use Auth;
  use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Retrieve all items in the cart
        $carts = Cart::with('product', 'product.productImages')->where('user_id', auth()->id())->where('status', 0)->get();

        return  response()->json(['data'=>$carts]);
    }


    public function store(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        // Log the authenticated user ID
        Log::info('Authenticated user ID:', ['user_id' => auth()->id()]);
    
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            // 'variation_id' => 'required|integer',
            // 'delivery_id' => 'required|integer',
        ]);
    
        // Fetch the product based on the provided product_id
        $product = Product::findOrFail($request->input('product_id'));
    
        // Calculate the total price based on the product's price and the quantity
        if ($product->offers()->first()) {
            $price = $product->offers()->first()->price;
            $totalPrice = $price * $request->input('quantity');
        } else {
            $price = $product->selling_price;
            $totalPrice = $price * $request->input('quantity');
        }
    
        // Check if the product is already in the cart for the authenticated user
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->input('product_id'))
            ->where('variation_id', $request->input('variation_id'))
            ->where('status', 0)
            ->first();
    
        if ($cartItem) {
            // Ensure that the quantity is greater than zero
            if ($cartItem->quantity <= 0) {
                // You can handle this case as per your requirements
                return response()->json(['message' => 'Quantity must be greater than zero'], 400);
            }
    
            // Product is already in the cart, update the quantity
            $cartItem->quantity += $request->input('quantity');
    
            // Ensure that the updated quantity is at least one
            if ($cartItem->quantity < 1) {
                // You can handle this case as per your requirements
                return response()->json(['message' => 'Quantity must be at least one'], 400);
            }
    
            // Recalculate total price based on the new quantity
            $cartItem->total_price_product = $price * $cartItem->quantity;
            $cartItem->price = $price;
            $cartItem->save();
    
            return response()->json($cartItem, 200);
        }
    
        // Product is not in the cart, create a new entry
        $cart = new Cart();
        $cart->user_id = auth()->id(); // Use authenticated user's ID directly
        $cart->product_id = $request->input('product_id');
        $cart->offer_id = $request->input('offer_id');
        $cart->variation_id = $request->input('variation_id');
        $cart->quantity = $request->input('quantity');
        $cart->price = $price;
        $cart->total_price_product = $totalPrice;
        $cart->status = 0;
        $cart->save();
    
        return response()->json($cart, 201);
    }



    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        // Find the cart item by ID
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);

        // Check if the product is already in the cart for the authenticated user
        $existingCartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $cart->product_id)
            ->where('id', '!=', $id) // Exclude the current cart item
            ->first();

        if ($existingCartItem) {
            // Product is already in the cart, you might want to handle this case
            // Maybe merge the quantities, or show an error message
            return response()->json(['message' => 'Product already in the cart'], 400);
        }

        // Ensure that the quantity is at least one
        if ($cart->quantity <= 0) {
            // You can handle this case as per your requirements
            return response()->json(['message' => 'Quantity must be at least one'], 400);
        }

        // Update the quantity
        $cart->quantity += $request->input('quantity');
        $totalPrice = $cart->product->selling_price * $cart->quantity;
        $cart->total_price_product = $totalPrice;
        $cart->save();

        return response()->json($cart);
    }


    public function destroy($id)
    {
        // Find the cart item by ID and delete it
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return response()->json(null, 204);
    }
}
