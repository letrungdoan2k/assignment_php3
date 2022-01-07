<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        $pagenumber  = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = 10;
//        $products = Product::orderByDesc('id')->skip($offset)->take($pagesize)->get();
        $products = Product::orderByDesc('id')->paginate($pagesize);
        return response()->json($products);
    }

    public function indexCate(Request  $request) {
        $categories = Category::orderByDesc('id')->get();

        return response()->json($categories);
    }

    public function indexBrand() {
        $brand = Brand::all();
        return response()->json($brand);
    }
    public function indexRole() {
        $role = Role::all();
        return response()->json($role);
    }

    public function detail($id) {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function saleTop()
    {
        $products = Product::orderByDesc('sale')->take(6)->get();
        return response()->json($products);
    }

    public function topLike()
    {
        $products = Product::orderByDesc('view')->take(12)->get();
        return response()->json($products);
    }

    public function relatedProduct($id) {
        $product = Product::where('id', $id)->first();
        $cate_id = $product->cate_id;
        $products = Product::where('cate_id', $cate_id)->where("id","!=",$product->id)->take(5)->get();
        return response()->json($products);
    }

    public function product() {
        $categories = Category::all();
        $products = Product::all();
        return view("client.product", compact('categories', 'products'));
    }
}
