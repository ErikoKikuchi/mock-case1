<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function register(RegisterRequest $request){
        $user = DB::transaction(function()use ($request){
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            ]);
        $user->profile()->create([
            'name' => $request->name,
        ]);
        return $user;
        });
        //メール認証を後で実装
        //event(new Registered($user));
        //自動ログイン
        auth()->login($user);
        return redirect()->intended(route('home'));
    }
    public function edit(){
        $user=Auth::user();
        return view('profile-edit',compact('user'));
    } 
}
