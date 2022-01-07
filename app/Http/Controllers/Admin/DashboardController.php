<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $product = Product::all()->count();
        $category = Category::all()->count();
        $user = User::all()->count();
        $brand = Brand::all()->count();
        return response()->json(compact('user', 'product', 'category', 'brand'));
    }
}
