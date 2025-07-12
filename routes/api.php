<?php
namespace App\Http\Controllers\Api\v1\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\User\AuthController;
use App\Http\Controllers\Api\v1\User\HomeController;
use App\Http\Controllers\Api\v1\User\CategoryController;
use App\Http\Controllers\Api\v1\User\ProductController;
use App\Http\Controllers\Api\v1\User\CartController;
use App\Http\Controllers\Api\v1\User\OrderController;
use App\Http\Controllers\Api\v1\User\FavouriteController;
use App\Http\Controllers\Api\v1\User\UserAddressController;
use App\Http\Controllers\Api\v1\User\ProductReviewController;
use App\Http\Controllers\Api\v1\User\BannerController;
use App\Http\Controllers\Api\v1\User\BranchController;
use App\Http\Controllers\Api\v1\User\CouponController;
use App\Http\Controllers\Api\v1\User\PaymentController;
use App\Http\Controllers\Api\v1\User\DeliveryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/terms-and-conditions', 'Api\v1\User\HomeController@terms_and_conditions'); // Done

Route::group(['prefix' => 'v1/user'], function () {

//Route unAuth
 Route::get('/latest',  [ProductController::class,'latest']); // Done

 Route::get('/offers', [ProductController::class,'offers']); // Done
Route::get('/banners', [BannerController::class,'index']); // Done
Route::get('/branches', [BranchController::class,'index']); // Done


          //----------------- Products ------------------------------//
   Route::get('/products', [ProductController::class,'index']); // Done
   Route::get('/products/{id}', [ProductController::class,'productDetails']); // Done

    //Category product
    Route::get('/categories/branch/{id}', [CategoryController::class, 'index']);
    
    // Get products for a specific category (with optional branch filter)
    // Usage: /api/categories/{categoryId}/products?branch_id={branchId}
    Route::get('/categories/{categoryId}/products', [CategoryController::class, 'getProducts']);
    
    
    // Get category with its products for a specific branch
    Route::get('/branches/{branchId}/categories/{categoryId}', [CategoryController::class, 'getCategoryWithProducts'])
        ->name('api.branches.category-products');


    //---------------- Auth --------------------//
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);



    Route::get('/app_data', 'Api\v1\User\AppDataController@getAppData');



    Route::group(['middleware' => ['auth:user-api']], function () {

        Route::get('/home', [HomeController::class,'index']);

        //---------------------------- App Data -------------------------//
        //App User Data
        Route::get('/app_data/user', 'Api\v1\User\AppDataController@getAppDataWithUser');

        //---------------------- Setting ----------------------------//
        Route::post('/update_profile', [AuthController::class,'updateProfile']);




        // mutasem
        Route::post('/language',  [AuthController::class,'language']); // Done.
        Route::get('/language',  [AuthController::class,'locale']); // Done
        Route::get('/notifications',  [AuthController::class,'notifications']); // Done



        Route::post('/mobileVerified', [AuthController::class,'mobileVerified']); // Done;
        //---------------------- Setting ----------------------------//

        Route::get('/user-profile', [AuthController::class,'userProfile']); // Done



          //--------------- Favourite ------------------------//
          Route::get('/favourites', [FavouriteController::class,'index']); // Done
          Route::post('/favourites', [FavouriteController::class,'store']); // Done

          //--------------- Coupon ------------------------//
          Route::post('/applyCoupon', [CouponController::class,'applyCoupon']); // Done


          Route::get('/delivery', [DeliveryController::class,'index']); // Done

          //-------------------- Address ------------------------//
          Route::get('/addresses', [UserAddressController::class,'index']); // Done
          Route::post('/addresses', [UserAddressController::class,'store']); // Done
          Route::post('/addresses/{address_id}', [UserAddressController::class,'update']); // Done
          Route::delete('/addresses/{id}', [UserAddressController::class,'destroy']); // Done
          //----------- Product Review ----------------------//
          Route::post('/product-reviews', [ProductReviewController::class,'store']); // Done


            //----------------- Cart -------------------------------//
            Route::get('/carts', [CartController::class,'index']); // Done
            Route::post('/carts', [CartController::class,'store']);// Done
            Route::post('/carts/{id}', [CartController::class,'update']);// Done
            Route::delete('/carts/{id}', [CartController::class,'destroy']);// Done


               //---------------------- Order -----------------------//
        Route::get('/orders', [OrderController::class,'index']);
        Route::get('/orders/{id}', [OrderController::class,'show']);
        Route::post('/orders/{id}', [OrderController::class,'update']);
       // Route::post('/orders', [OrderController::class,'store']); // Done
        Route::get('/orders/{id}/cancel', [OrderController::class,'cancel_order']);
        Route::post('/orders/{id}/refund', [OrderController::class,'refund']);


       Route::post('/orders', [PaymentController::class, 'store']);
    
        // Check payment status
        Route::get('/payments/status', [PaymentController::class, 'checkPaymentStatus']);
        
        // Test connection (for development)
        Route::get('/payments/test-connection', [PaymentController::class, 'testConnection']);


        // Payment callback routes (no auth required as they come from payment gateway)
        Route::get('/payments/success', [PaymentController::class, 'paymentSuccess']);
        Route::get('/payments/cancel', [PaymentController::class, 'paymentCancel']);


    });

    Route::get('/maintenance', function () {
        return response(['message' => ['Course is now online']], 200);
    });


});
