<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    public function register(RegisterRequest $request){
        $user = DB::transaction(function()use ($request){
        $user = app(CreateNewUser::class)->create($request->validated());
        $user->profile()->create([
            'name' => $request->input('name'),
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
