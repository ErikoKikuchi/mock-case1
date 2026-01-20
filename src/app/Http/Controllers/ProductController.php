<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function create()
    {
        $products =Product::all();
        $categories=Category::all();
        return view('exhibition',compact('products','categories'));
    }
    public function index(Request $request){
        $user = Auth::user();
        return view('mypage', compact('user'));
    }
    public function show(Product $item_id)
    {
        $item_id->load(['categories','comments.user.profile'])
            ->loadCount(['likes','comments']);

        return view('detail',['product'=>$item_id]);
    }
}
