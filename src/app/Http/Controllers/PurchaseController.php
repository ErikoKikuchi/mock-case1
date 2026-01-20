<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show(Product $item_id)
    {
        $user=Auth::user();
        //自分の商品は変えない
        if($user->isSellerOf($item_id))
            {abort(403);
        }
        //売り切れ
        if($item_id->isSold())
            {
                return redirect()
                ->route('products.show',$item_id)
                ->with('error','この商品は売り切れです');
            }
        return view('purchase',compact('item_id'));
    }

}
