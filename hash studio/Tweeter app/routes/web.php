<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\SharesController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\followsController;
use App\Http\Controllers\followssController;
use App\Http\Controllers\FavouritesController;
use App\Http\Controllers\TweetsTrashController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



//?start//
// todo group user to login & logout & register //
Route::group(['prefix' =>'users'], function () {
    // todo return image users //

    // todo Login
    Route::get('/login', [UserController::class, 'loginIndex'])->name('loginindex');
    Route::POST('/login/check', [UserController::class, 'login'])->name('login');
    Route::get('/login/checklogin',function (){redirect(route('logout'));});
    Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('Auth');
    Route::POST('/regist/create', [UserController::class, 'register'])->name('register');
    Route::get('/regist', [UserController::class, 'registerIndex'])->name('registerIndex');
    Route::get('/profile', [UserController::class, 'index'])->name('users.indexs');
    Route::get('/followers', [followsController::class, 'followers'])->name('followers.indexs');
    Route::get('/following', [followsController::class, 'following'])->name('following.indexs');
    Route::POST('/unfollow', [followsController::class, 'unfollow'])->name('follow.unfollow');
    Route::get('/settings/{user}', [UserController::class, 'edit'])->name('user.settings');
    Route::PUT('/settings/{user}', [UserController::class, 'update'])->name('user.update');

    //// ? todo change image of user ////
    Route::POST('/change-img',[UserController::class, 'changeimg'])->middleware('Auth')->name('users.image');

});
//?end//

//?start//
Route::middleware('Auth')->group(function () {
    // ? tweets end point resource
    Route::resource('/tweets', TweetsController::class);
    Route::POST('/explore/{tweet}',[TweetsController::class, 'explore'])->name('exploreindex');
    Route::get('/share/{tweet}',[TweetsController::class, 'share'])->name('shareindex');
    Route::POST('/share/{tweet}',[TweetsController::class, 'shareStore'])->name('share.store');

    Route::POST('/report/{tweet}',[TweetsController::class, 'report'])->name('reportindex');
    Route::get('/search',[TweetsController::class, 'autocompleteSearch'])->name('searchindex');
    Route::get('/explore-all',[TweetsController::class, 'exploreall'])->name('explore-allindex');


    //? restore tweets 
    Route::get('/restore/index',[TweetsTrashController::class, 'restoreindex'])->name('trashindex');
    Route::get('/restore',[TweetsTrashController::class, 'restore'])->name('restore');
    Route::get('/destroy/Force',[TweetsTrashController::class, 'destroyForce'])->name('destroy-Force');


    // ? favourite end point resource
    Route::resource('/fav-tweet', FavouritesController::class);

    // ? follow end point resource
    Route::resource('/follow', followsController::class);

    // ? likes end point resource
    Route::resource('/likes', LikesController::class);

    // ? likes end point resource
    Route::resource('/shares', SharesController::class);

});
//?end//