<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class ProductInteractionController extends Controller
{
    public function toggle(Product $product)
    {
        auth()->user()->toggleLike($product);

        return back();
    }
    public function store(CommentRequest $request,Product $item_id)
    {
        Comment::create([
            'body'=>$request->body,
            'user_id'=>Auth::id(),
            'product_id'=>$item_id->id,
            ]);

        return redirect()->back();
    }
}
