<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get("/cashier", [ProductController::class, 'cashier']);

Route::get("/search", [ProductController::class, 'search']);

Route::post("/add_to_buy", [ProductController::class, 'addToBuy']);


Auth::routes();
