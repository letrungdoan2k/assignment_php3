<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function saveAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'price' => 'required|min:0|integer',
            'image' => 'required',
            'quantity' => 'required|nullable|integer|min:0',
            'price_sale' => 'min:0',//|before:price
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        } else {
            $model = new Product();
            if ($request->price_sale != null) {
                $model->sale = 100 - (($request->price_sale / $request->price) * 100);
            }
            $model->fill($request->all());
            $model->save();
        }
    }

    public function edit($id)
    {
        $products = Product::find($id);
        if (!$products) {
            return back();
        }
        return response()->json($products);
    }

//
    public function saveEdit(Request $request, $id)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => [
//                'required',
////                Rule::unique('products')->ignore($this->$id)
//            ],
//            'price' => 'required|min:0|integer',
//            'image' => '',
//            'quantity' => 'required|nullable|integer|min:0',
//            'price_sale' => 'min:0',//|before:price
//            'description' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'success' => false,
//                'errors' => $validator->errors()
//            ]);
//        } else {
        $model = Product::find($id);
        if (!$model) {
            return back();
        }
        if ($request->price_sale != null) {
            $model->sale = 100 - (($request->price_sale / $request->price) * 100);
        }else {
            $model->sale = null;
        }
        $model->fill($request->all());
        $model->save();
//        }
    }

    public function remove($id)
    {
        $model = Product::find($id);
        $model->delete();
    }
}
