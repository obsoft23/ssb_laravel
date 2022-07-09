<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsAPiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VocationsController;

use App\Http\Controllers\BusinessAccountController;




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

});

Route::post('/auth/login', [UserController::class, 'index']);
Route::post('/auth/register', [UserController::class, 'register']);
Route::get('/fetch-user-image/{imageURL}', [UserController::class, 'user_profile_picture']);
Route::get('/fetch-business-acc-image/{imageURL}', [BusinessAccountController::class, 'business_profile_pictures']);
Route::get('/business-photos/fetch/{id}', [BusinessAccountController::class, 'fetchBusinessPhotos']);
Route::get('/business-profile/fetch/{id}', [BusinessAccountController::class, 'show']);
Route::post('/vocations/fetch', [VocationsController::class, 'getVocations']);



Route::post('/upload', [CategoryController::class, 'index']);
Route::post('/import', [VocationsController::class, 'vocations']);

/*Route::get('/posts', [PostsAPiController::class, 'index']);

Route::post('/posts', [PostsAPiController::class, 'store']);

Route::put('/posts/{post}', [PostsAPiController::class, 'update']);
Route::delete('/posts/{post}', [PostsAPiController::class, 'destroy']);*/


