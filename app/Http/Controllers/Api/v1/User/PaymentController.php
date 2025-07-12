<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Payment;



class PaymentController extends Controller
{
    private $gatewayUrl = 'https://test-network.mtf.gateway.mastercard.com/api/';
    private $merchantId = 'TESTNITEST2';
    private $apiUsername = 'merchant.TESTNITEST2';
    private $apiPassword = 'ac63181fe688fe7ce3cf5a1f105a145a';

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $request->validate([
            'payment_type' => 'required|string',
            'address_id' => 'required',
        ]);

        // Find all the cart items with status 0 for the current user
        $cartItems = Cart::where('user_id', $user_id)->where('status', 0)->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'No items in cart'], 400);
        }

        // Calculate totals
        $total_discounts = 0;
        $delivery_fee = 0;
        $total_taxes = 0;
        $total_prices = 0;
        $totalPriceBeforeTaxSum = 0;
        
        $address = Address::with('delivery')->where('id', $request->input('address_id'))->first();
        $delivery_fee = $address->delivery->price ?? 0;
        
        foreach ($cartItems as $cartItem) {
            $total_discounts = $cartItem->discount_coupon ?? 0;
            $total_taxes = $cartItem->product->tax ?? 0;
            $total_prices += $cartItem->total_price_product;
        }

        // Create a new order with pending status
        $order = new Order([
            'address_id' => $request->input('address_id'),
            'payment_type' => $request->input('payment_type'),
            'total_discounts' => $total_discounts,
            'delivery_fee' => $delivery_fee,
            'total_taxes' => $total_taxes,
            'total_prices' => $total_prices + $delivery_fee,
            'date' => now(),
            'user_id' => auth()->id(),
            'order_status' => 1, // 1 = Pending
            'payment_status' => 2, // 2 = Unpaid
        ]);
        $order->save();

        // Calculate discount percentage and attach products
        foreach ($cartItems as $cartItem) {
            $total_price_after_tax_for_result = $cartItem->price * $cartItem->quantity;
            $total_price_before_tax_for_result = $total_price_after_tax_for_result / (1 + ($cartItem->product->tax / 100));
            $totalPriceBeforeTaxSum += $total_price_before_tax_for_result;
        }
        
        $final_result_total_price_before_tax = $totalPriceBeforeTaxSum;
        $discount_percentage = $total_discounts > 0 ? $total_discounts / $final_result_total_price_before_tax : 0;

        foreach ($cartItems as $cartItem) {
            $total_price_after_tax = $cartItem->price * $cartItem->quantity;
            $total_price_before_tax = $total_price_after_tax / (1 + ($cartItem->product->tax / 100));
            
            $order->products()->attach($cartItem->product_id, [
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'variation_id' => $cartItem->variation_id,
                'total_price_after_tax' => $total_price_after_tax,
                'total_price_before_tax' => $total_price_before_tax,
                'tax_percentage' => $cartItem->product->tax,
                'discount_percentage' => $discount_percentage,
                'discount_value' => $discount_percentage * $total_price_before_tax,
                'tax_value' => ($total_price_before_tax - ($discount_percentage * $total_price_before_tax)) * ($cartItem->product->tax / 100),
            ]);
        }

        // Handle payment based on type
        if (strtolower($request->input('payment_type')) === 'visa') {
            // Create hosted session for visa payments
            $sessionResponse = $this->createHostedSession($order);
            
            if (isset($sessionResponse['error'])) {
                return response()->json([
                    'error' => 'Payment session creation failed',
                    'message' => $sessionResponse['error'],
                    'order_id' => $order->id
                ], 400);
            }

            return response()->json([
                'order' => $order,
                'payment_type' => 'visa',
                'session_id' => $sessionResponse['session_id'],
                'hosted_session_js_url' => $sessionResponse['hosted_session_js_url'],
                'message' => 'Use hosted session for payment form'
            ], 200);

        } else {
            // For cash payments - complete immediately
            Cart::where('user_id', $user_id)->where('status', 0)->update(['status' => 1]);
            $order->update(['order_status' => 2]); // 2 = Confirmed

            return response()->json([
                'order' => $order,
                'payment_type' => 'cash',
                'message' => 'Order confirmed - Cash on delivery'
            ], 200);
        }
    }

    /**
     * Create hosted session for payment form
     */
    public function createHostedSession(Order $order)
    {
        try {
            $sessionId = $this->generateSessionId();
            
            // Create session using NVP format for better compatibility
            $postData = http_build_query([
                'apiOperation' => 'CREATE_SESSION',
                'apiPassword' => $this->apiPassword,
                'apiUsername' => $this->apiUsername,
                'merchant' => $this->merchantId,
                'session.id' => $sessionId
            ]);

            Log::info('Creating hosted session', [
                'session_id' => $sessionId,
                'order_id' => $order->id,
                'url' => $this->gatewayUrl . 'nvp/version/73'
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->gatewayUrl . 'nvp/version/73', $postData);

            Log::info('Hosted session response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseBody = $response->body();
                parse_str($responseBody, $responseData);
                
                if (isset($responseData['result']) && $responseData['result'] === 'SUCCESS') {
                    // Store payment record
                    Payment::create([
                        'order_id' => $order->id,
                        'session_id' => $sessionId,
                        'amount' => $order->total_prices,
                        'currency' => 'USD',
                        'status' => 'session_created',
                        'gateway_response' => json_encode($responseData)
                    ]);

                    // Return session details for hosted form
                    $hostedSessionJsUrl = "https://test-network.mtf.gateway.mastercard.com/form/version/73/merchant/{$this->merchantId}/session.js?session={$sessionId}";

                    return [
                        'session_id' => $sessionId,
                        'hosted_session_js_url' => $hostedSessionJsUrl,
                        'status' => 'session_created'
                    ];
                }
            }

            return ['error' => 'Failed to create hosted session: ' . $response->body()];

        } catch (\Exception $e) {
            Log::error('Hosted session creation exception', [
                'error' => $e->getMessage()
            ]);
            return ['error' => 'Payment system error: ' . $e->getMessage()];
        }
    }

    /**
     * Process payment using hosted session
     */
    public function processHostedSessionPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'session_id' => 'required|string'
        ]);

        $order = Order::findOrFail($request->order_id);
        $user_id = auth()->user()->id;

        // Verify order belongs to authenticated user
        if ($order->user_id !== $user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $transactionId = $this->generateTransactionId();
            
            // Process payment using the session
            $postData = http_build_query([
                'apiOperation' => 'PAY',
                'apiPassword' => $this->apiPassword,
                'apiUsername' => $this->apiUsername,
                'merchant' => $this->merchantId,
                'order.id' => (string)$order->id,
                'order.amount' => number_format($order->total_prices, 2, '.', ''),
                'order.currency' => 'USD',
                'session.id' => $request->session_id,
                'transaction.id' => $transactionId
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->gatewayUrl . 'nvp/version/73', $postData);

            $responseBody = $response->body();
            parse_str($responseBody, $responseData);

            // Update payment record
            $payment = Payment::where('order_id', $order->id)->where('session_id', $request->session_id)->first();
            if (!$payment) {
                $payment = new Payment([
                    'order_id' => $order->id,
                    'session_id' => $request->session_id,
                    'amount' => $order->total_prices,
                    'currency' => 'USD'
                ]);
            }

            $payment->transaction_id = $transactionId;
            $payment->gateway_response = json_encode($responseData);

            if ($response->successful() && isset($responseData['result']) && $responseData['result'] === 'SUCCESS') {
                // Payment successful
                $payment->status = 'completed';
                $payment->save();

                $order->update([
                    'order_status' => 2, // 2 = Confirmed
                    'payment_status' => 1 // 1 = Paid
                ]);
                
                // Update cart status
                Cart::where('user_id', $user_id)->where('status', 0)->update(['status' => 1]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment completed successfully',
                    'order' => $order,
                    'transaction_id' => $transactionId
                ], 200);

            } else {
                // Payment failed
                $payment->status = 'failed';
                $payment->save();

                $order->update([
                    'order_status' => 5, // 5 = Failed
                    'payment_status' => 2 // 2 = Unpaid
                ]);

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Payment failed',
                    'error' => $responseData['error.explanation'] ?? 'Unknown error',
                    'order_id' => $order->id
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Hosted session payment processing failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment processing failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check payment status (for mobile app to poll)
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::with('payment')->findOrFail($request->order_id);
        $user_id = auth()->user()->id;

        if ($order->user_id !== $user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'order_status_text' => $this->getOrderStatusText($order->order_status),
            'payment_status' => $order->payment_status,
            'payment_status_text' => $this->getPaymentStatusText($order->payment_status),
            'payment_details' => $order->payment ? [
                'status' => $order->payment->status,
                'session_id' => $order->payment->session_id,
                'transaction_id' => $order->payment->transaction_id,
            ] : null
        ]);
    }

    /**
     * Generate unique session ID - must be at least 31 characters as per Mastercard requirements
     */
    private function generateSessionId()
    {
        // Generate a session ID that's at least 31 characters
        $timestamp = time();
        $random = uniqid() . rand(100, 999);
        return 'SESSION_' . $timestamp . '_' . $random;
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId()
    {
        return 'TXN_' . time() . '_' . uniqid();
    }

    /**
     * Test connection to payment gateway
     */
    public function testConnection()
    {
        try {
            // Test session creation
            $testSessionId = $this->generateSessionId();
            $postData = http_build_query([
                'apiOperation' => 'CREATE_SESSION',
                'apiPassword' => $this->apiPassword,
                'apiUsername' => $this->apiUsername,
                'merchant' => $this->merchantId,
                'session.id' => $testSessionId
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->gatewayUrl . 'nvp/version/73', $postData);

            $responseBody = $response->body();
            parse_str($responseBody, $responseData);

            return response()->json([
                'status' => ($responseData['result'] ?? '') === 'SUCCESS' ? 'connected' : 'failed',
                'response' => $responseData,
                'test_session_id' => $testSessionId,
                'hosted_js_url' => "https://test-network.mtf.gateway.mastercard.com/form/version/73/merchant/{$this->merchantId}/session.js?session={$testSessionId}"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get order status text
     */
    private function getOrderStatusText($status)
    {
        $statusMap = [
            1 => 'Pending',
            2 => 'Confirmed',
            3 => 'On The Way',
            4 => 'Cancelled',
            5 => 'Failed',
            6 => 'Refund',
            7 => 'Delivered'
        ];

        return $statusMap[$status] ?? 'Unknown';
    }

    /**
     * Get payment status text
     */
    private function getPaymentStatusText($status)
    {
        $statusMap = [
            1 => 'Paid',
            2 => 'Unpaid'
        ];

        return $statusMap[$status] ?? 'Unknown';
    }
}