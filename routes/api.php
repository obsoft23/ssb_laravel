<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsAPiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VocationsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\BusinessAccountController;
use App\Http\Controllers\CommonController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});


Route::group(["middleware" => "auth:sanctum"], function(){
    Route::post('/auth/update', [UserController::class, 'update']);
    Route::get('/profile/fetch', [UserController::class, 'show']);
   
    Route::put('/profile/update/{id}', [UserController::class, 'update']);
    Route::put('/access/update/{id}', [UserController::class, 'edit']);
    Route::post('/profile/image/{id}', [UserController::class, 'updateImage']);

    /* business/create */
    Route::post('/business/create', [BusinessAccountController::class, 'create']);
    Route::post('/business/photos/add', [BusinessAccountController::class, 'managePhotos']);
    Route::post('/business/photos/delete', [BusinessAccountController::class, 'destroy']);
   
    /*business <update></update>*/
    Route::post('/business/update/active_days', [BusinessAccountController::class, 'active_days']);
    Route::post('/business/update/address', [BusinessAccountController::class, 'update_address']);
    Route::post('/business/update/details', [BusinessAccountController::class, 'update_details']);
    Route::post('/business/update/hours', [BusinessAccountController::class, 'update_hours']);


    /*rate */
    Route::post('/business/update/rating', [RatingController::class, 'rate']);


    /*likes */
    Route::post('/business/update/like', [LikesController::class, 'create']);
    Route::post('/business/confirm/like', [LikesController::class, 'show']);

    /*review */
   
    Route::post('/business/confirm/review', [ReviewController::class, 'create']);
    Route::post('/business/confirm/review/delete', [ReviewController::class, 'destroy']);

    /*saved favourites*/
    Route::post('/business/confirm/favourite', [FavouriteController::class, 'create']);
    Route::post('/business/fetch/favourite', [FavouriteController::class, 'show']);
    Route::post('/business/confirm/favourite/delete', [FavouriteController::class, 'destroy']);
    Route::post('/vocations/find', [BusinessAccountController::class, 'getVocations']);

});

Route::post('/auth/login', [UserController::class, 'index']);
Route::post('/auth/register', [UserController::class, 'register']);

Route::get('/vocation/{imageURL}', [VocationsController::class, 'vocation_photo']);
Route::get('/fetch-user-image/{imageURL}', [UserController::class, 'user_profile_picture']);
Route::get('/fetch-business-acc-image/{imageURL}', [BusinessAccountController::class, 'business_profile_pictures']);
Route::get('/business-photos/fetch/{id}', [BusinessAccountController::class, 'fetchBusinessPhotos']);
Route::get('/business-profile/fetch/{id}', [BusinessAccountController::class, 'show']);
Route::get('/vocations/fetch', [VocationsController::class, 'getVocations']);
//Route::get('/vocations/common', [CommonController::class, 'index']);

Route::get('/business/fetch/review/{id}', [ReviewController::class, 'show']);


Route::post('/upload', [CategoryController::class, 'index']);
Route::post('/import', [VocationsController::class, 'vocations']);
Route::post('/import/users', [UserController::class, 'upload_user']);
Route::post('/import/business_acc', [BusinessAccountController::class, 'upload_business_acc']);


/*Route::get('/posts', [PostsAPiController::class, 'index']);

Route::post('/posts', [PostsAPiController::class, 'store']);

Route::put('/posts/{post}', [PostsAPiController::class, 'update']);
Route::delete('/posts/{post}', [PostsAPiController::class, 'destroy']);*/


