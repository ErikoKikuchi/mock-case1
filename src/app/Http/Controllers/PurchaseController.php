<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\ShippingAddress;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $user=Auth::user();
        $product=Product::findOrFail($item_id);

        //自分の商品は変えない
        if($user->isSellerOf($product))
            {abort(403);
        }

        //売り切れ
        if($product->isSold())
            {
                return redirect()
                ->route('home',$product)
                ->with('error','この商品は売り切れです');
            }
            $selectedPayment=null;
            $profile = $user?->profile;
             $shippingAddress = ShippingAddress::where('user_id', $user->id)->first();

        return view('purchase', [
        'product' => $product,
        'selectedPayment' => $selectedPayment,
        'profile' => $user?->profile,
        'shippingAddress' => $shippingAddress, 
    ]);
    }
    public function edit($item_id)
    {
        $user=Auth::user();
        $product = Product::findOrFail($item_id);
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
    public function update(Request $request,$item_id)
    {
    $user = Auth::user();
    $product = Product::findOrFail($item_id);
    
    $shipping = ShippingAddress::updateOrCreate(
        ['user_id' => $user->id, 'product_id' => $product->id], 
        [
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building
            ]
     );

    return redirect()->route('purchase.show', ['item_id' => $product->id]);
    }
}
