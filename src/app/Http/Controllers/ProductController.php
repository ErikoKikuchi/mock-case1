<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;

class ProductController extends Controller
{
    public function show()
    {
        $products =Product::all();
        $categories=Category::all();
        $conditions=Condition::all();
        return view('mypage',compact('products','categories','conditions'));
    }
    public function index(Request $request){
        $user = Auth::user();
        return view('mypage', compact('user'));
    }
}
