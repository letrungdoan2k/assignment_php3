<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    public function saveAdd(Request $request) {
        $model = new Brand();
        $model->fill($request->all());
        $model->save();
    }

    public function  remove($id) {
        $model = Brand::find($id);
        Product::where("cate_id", $id)->delete();
        $model->delete();
    }
}
