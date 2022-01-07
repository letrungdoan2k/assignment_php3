<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    public function saveAdd(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        } else {
            $model = new Category();
            $model->fill($request->all());
            $model->save();
        }
    }

    public function edit($id) {
        $model = Category::find($id);
        if(!$model){
            return back();
        }
        return response()->json($model);
    }

    public function saveEdit(CategoryRequest $request,$id) {
        $model = Category::find($id);
        if(!$model) {
            return back();
        }
        $model->fill($request->all());
        $model->save();
    }

    public function remove($id) {
        $model = Category::find($id);
        Product::where("cate_id", $id)->delete();
        $model->delete();
    }
}
