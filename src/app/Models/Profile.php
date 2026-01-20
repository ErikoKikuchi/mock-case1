<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[
        'name',
        'image',
        'post_code',
        'address',
        'building',
        'user_id',
    ];

//他テーブルとの関係
    public function users()
    {
        return $this->belongsTo(User::class);
    }
//ロジック系
    //必須項目が埋まっているか
    public function isComplete():bool
    {
        return !empty($this->name)&&
            !empty($this->post_code)&&
            !empty($this->address);
    }
}
