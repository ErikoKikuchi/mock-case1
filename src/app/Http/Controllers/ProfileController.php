<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
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
        $profile=$user->profile;
        return view('profile-edit',compact('profile'));
    } 
    public function update(ProfileRequest $request)
    {
        $user=Auth::user();
        $data =[
            'name'=>$request->name,
            'post_code'=>$request->post_code,
            'address'=>$request->address,
            'building'=>$request->building,
        ];

         if( $request->file('image')){
            $originalName=$request->file('image')->getClientOriginalName(); 
            $data['image'] =$request->file('image')->storeAs('images', $originalName,'public');
            }
            $user->profile->update($data);

        return redirect()->route('profile.edit')->with('message','プロフィール変更が完了しました');
    }
}
