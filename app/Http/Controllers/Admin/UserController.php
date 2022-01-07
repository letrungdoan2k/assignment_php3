<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index() {
        $users = User::all();
        $users->load(['hasRole']);
        return response()->json($users);
    }

    public function edit($id)
    {
        $model = User::find($id);
        if (!$model) {
            return back();
        }
        return response()->json($model);
    }

    public function saveEdit($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $model = User::find($id);
        if (!$model) {
            return back();
        }
        $model['password'] = bcrypt($model['password']);
        $model->fill($request->all());
        $model->save();
        $model->assignRole($request->role);
    }

    public function remove($id)
    {
        $model = User::find($id);
        $model->delete();
    }
}
