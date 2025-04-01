<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//?start//
// ! all routes / api here must be authentcated
Route::group(['middleware' => ['api']], function () {


    //?start//
    // todo group user to login & logout & register //
    Route::group(['prefix' =>'users'], function () {
      
        Route::POST('/login', [UserController::class, 'login']);
        Route::POST('/regist',[UserController::class, 'register']);
        
        // todo return image users //
        Route::get('/imageusers/{avatar}',[UserController::class, 'imagesuser']);

        Route::POST('/logout',[UserController::class, 'logout'])->middleware('auth.guard:api');
        //// ? return profile information ////
        Route::get('/profile',[UserController::class, 'profile'])->middleware('auth.guard:api');
   
    });
    //?end//


    //?start//
    // todo group categories //
    Route::group(['prefix' =>'cat'], function () {
     
        Route::GET('/retrieve/categories', [CategoriesController::class, 'index'])->middleware('auth.guard:api');;
        // todo return image cat //
        Route::get('/imagecat/{cat}',[CategoriesController::class, 'imagescat']);

    });
    //?end//

    //?start//
    // todo group Tasks  //
    Route::group(['middleware' => ['auth.guard:api']], function () {
    Route::group(['prefix' =>'task'], function () {
        
        Route::GET('/retrieve/tasks', [TasksController::class, 'index']);
        Route::POST('/new/task', [TasksController::class, 'store']);
        Route::GET('/edit/task', [TasksController::class, 'edit']);
        Route::PUT('/update/task', [TasksController::class, 'update']);
        Route::DELETE('/soft-deleted/task', [TasksController::class, 'destroy']);
        Route::GET('/filtering/tasks', [TasksController::class, 'filter']);
        Route::GET('/retrieve/tasks/trashed', [TasksController::class, 'restoreindex']);
        Route::POST('/restore/tasks', [TasksController::class, 'restore']);
        Route::GET('/auto/complete/search', [TasksController::class, 'autocolmpletesearch']);

    });
    });
    //?end//


    
});
//?end//