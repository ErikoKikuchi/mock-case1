<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;

class ProductSearchController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email','password'))){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()
        ->withErrors(['password' => 'ログイン情報が登録されていません'])
        ->onlyInput('email');
    }
    public function show(Request $request)
    {
        $user = Auth::user();
        //未ログインの時は全商品ページ
        if(!$user){
            $products =Product::all();
            $categories=Category::all();
            $conditions=Condition::all();
            return view('index',compact('products','categories','conditions'));
        }
        //ログイン済、profile未完成のときはprofile-editへ
        if(!$user->canViewProductList()){
            return redirect('/profile-edit');
        }
        //ログイン済、profile完成済のときはmypageへ
        $products =Product::all();
        $categories=Category::all();
        $conditions=Condition::all();
        return view('index',compact('products','categories','conditions'));
    }
}
