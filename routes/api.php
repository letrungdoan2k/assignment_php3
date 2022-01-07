<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// auth

Route::group(["namespace" => "App\Http\Controllers\Auth"], function () {
    Route::post('signup', "AuthController@register");
    Route::post('signin', "AuthController@login");
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('details', 'AuthController@details');
        Route::get('logout', "AuthController@logout");
    });

});

// web

Route::group(["namespace" => "App\Http\Controllers\Client"], function () {
    Route::prefix('client')->group(function () {
        Route::get("/products", "HomeController@index");
        Route::get("/products/detail/{id}", "HomeController@detail");
        Route::get("/sale", "HomeController@saleTop");
        Route::get("/like", "HomeController@topLike");
        Route::get("/related/{id}", "HomeController@relatedProduct");
        Route::get("/products/search", "HomeController@search");

        Route::get("/categories", "HomeController@indexCate");

        Route::get("/brands", "HomeController@indexBrand");

        Route::get("/roles", "HomeController@indexRole");

    });
});

Route::group(["namespace" => "App\Http\Controllers\Cart"], function () {
    Route::get("/carts/{id}", "CartController@index");
    Route::post("/carts", "CartController@saveAdd");

});
// admin

Route::group(["namespace" => "App\Http\Controllers\Admin"], function () {
    Route::prefix('admin')->group(function () {
        Route::get("/dashboard", "DashboardController@index");

        ///
        Route::prefix("/products")->middleware(['role:admin'])->group(function () {
            Route::post("/", "ProductController@saveAdd");
            Route::delete("/remove/{id}", "ProductController@remove");
            Route::get("/{id}", "ProductController@edit");
            Route::patch("/{id}", "ProductController@saveEdit");
        });

        ////
        Route::prefix("/categories")->middleware('admin-role')->group(function () {
            Route::post("/", "CategoryController@saveAdd");
            Route::delete("/remove/{id}", "CategoryController@remove");
            Route::get("/{id}", "CategoryController@edit");
            Route::patch("/{id}", "CategoryController@saveEdit");
        });


        ///

        Route::post("/brands", "BrandController@saveAdd");
        Route::delete("/brands/remove/{id}", "BrandController@remove");
        Route::get("/brands/{id}", "BrandController@detail");

        ///
        Route::get("/users", "UserController@index");
        Route::post("/users", "UserController@saveAdd");
        Route::delete("/users/remove/{id}", "UserController@remove");
        Route::get("/users/{id}", "UserController@edit");
        Route::patch("/users/{id}", "UserController@saveEdit");

        //
        Route::post("/roles", "RoleController@saveAdd");
    });
});
