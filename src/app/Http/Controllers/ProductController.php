<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Profile;

class ProductController extends Controller
{
    public function create()
    {
        $products =Product::all();
        $categories=Category::all();
        return view('exhibition',compact('products','categories'));
    }
    public function index(Request $request){
        $user = auth()->user();
        $profile=$user->profile;
        $tab = $request->query('tab', 'isSellerOf');

        if ($tab === 'isSellerOf') {
            $products = $user->products; // 出品した商品
        } else {
        // 購入した商品のみ取得、productテーブルと結合してまとめて取得
            $products = Product::whereIn('id', function($query)use ($user) {
            $query->select('product_id')
                  ->from('purchases')
                  ->where('buyer_user_id', $user->id);
            })->get();
        }
    return view('mypage', compact('profile','products', 'tab'));
    }
    public function show(Product $item_id)
    {
        $item_id->load(['categories','comments.user.profile'])
            ->loadCount(['likes','comments']);

        return view('detail',['product'=>$item_id]);
    }
}
