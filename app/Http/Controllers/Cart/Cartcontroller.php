<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cartcontroller extends Controller
{
    public function index($id) {


    }

    public function saveAdd(Request $request) {
        dd($request->all());
    }
}
