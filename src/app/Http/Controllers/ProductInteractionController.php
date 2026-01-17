<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductInteractionController extends Controller
{
    public function toggle(Product $product)
    {
        $liked = auth()->user()->toggleLike($product->id);

        return redirect()->back();
    }
}
