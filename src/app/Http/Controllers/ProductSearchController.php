<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\Product;
use App\Models\Category;

class ProductSearchController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email','password'))){
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        return back()
        ->withErrors(['password' => 'ログイン情報が登録されていません'])
        ->onlyInput('email');
    }
    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');
        //未ログインの時は全商品ページ,マイリストタブは空表示
        if(!$user){
            $products = ($tab ==='mylist')
            ? collect():Product::keywordSearch($keyword)->get();
            return view('index',compact('products','tab'));
        }
        //ログイン済、profile未完成のときはprofile-editへ
        if(!$user->canViewProductList()){
            return redirect()->route('profile.edit');
        }
        //ログイン済、profile完成済のときは自分の出品商品以外の全商品ページへ,マイリストタブ押したらいいねした商品を表示
        if($tab === 'mylist'){
        $products =$user 
            -> likes()
            ->where('products.user_id', '!=', $user->id)
            ->keywordSearch($keyword)
            ->get();
        }else{
            $products= Product::where('user_id', '!=', $user->id)
            ->keywordSearch($keyword)
            ->get();
        }
        return view('index',compact('products','tab'));
    }
}
