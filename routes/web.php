<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FinishController;

use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// set my homepage function route
Route::get("/", [ProductController::class, 'index']);
// set route for add product
Route::get("/product/create", [ProductController::class, 'create']);
// set post route to save the product
Route::post("/product", [ProductController::class, 'store']);
// set get route to show the cashier view
Route::get("/cashier", [ProductController::class, 'cashier']);
// for the search route from the ajax search script and return the name
Route::get("/search", [ProductController::class, 'search']);
// the post from the form to store the name data to the Buy table
Route::post("/add_to_buy", [ProductController::class, 'addToBuy']);

Route::get("removebuy/{id}", [ProductController::class, 'removeBuy']);

Route::post("checkout", [ProductController::class, 'checkout']);

Route::post("checkoutplace", [ProductController::class, 'checkoutPlace']);

Route::get("/history", [FinishController::class, 'index']);




// for the authentication from laravel
Auth::routes();
