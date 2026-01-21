<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function show(Product $item_id)
    {
        $user=Auth::user();
        $product=$item_id;

        //自分の商品は変えない
        if($user->isSellerOf($product))
            {abort(403);
        }

        //売り切れ
        if($product->isSold())
            {
                return redirect()
                ->route('products.show',$product)
                ->with('error','この商品は売り切れです');
            }
            session(['purchase_item' => $product]);
            $selectedPayment=null;
        return view('purchase', [
        'product' => $product,
        'selectedPayment' => $selectedPayment,
        'address' => $user?->profile ?? null,
    ]);
    }
    public function edit()
    {
        $user=Auth::user();
        $product = session('purchase_item');
        return view ('address',compact('user', 'product'));
    }
    public function store(Request $request)
    {
        $request->validate([
        'product_id' => 'required|exists:products,id',
        'payment_method_id' => 'required|string|in:convenience,card',
        ]);

        $user = Auth::user();

        $purchase = Purchase::create([
        'buyer_user_id' => $user->id,
        'seller_user_id' => Product::find($request->product_id)->user_id,
        'product_id' => $request->product_id,
        'payment_method' => $request->payment_method_id,
        'status' => ' ',
        ]);
        return redirect()->route('mypage')->with('success','購入が完了しました');
    }
    public function update(Request $request)
{
    $user = Auth::user();
    $product = session('purchase_item');
     $shipping = ShippingAddress::updateOrCreate(
        ['user_id' => $user->profile->id], 
        [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building
            ]
     );
    return redirect()->route('purchase.show', ['item_id' => $item->id]);
}
}
