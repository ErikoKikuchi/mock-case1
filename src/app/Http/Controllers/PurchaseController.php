<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function show(Request $request,$item_id)
    {
        $user=Auth::user();
        $product=Product::findOrFail($item_id);

        //自分の商品は変えない
        if ($user->isSellerOf($product)) {
        return redirect()
        ->route('home')
        ->with('message', 'ご自分の商品は購入できません');
    }

        //売り切れ
        if($product->isSold())
            {
                return redirect()
                ->route('home',$product)
                ->with('message','この商品は売り切れです');
            }
        $selectedPayment=session('selected_payment', null);
        $profile = $user?->profile;
        $shippingAddress = null;
        if ($request->filled('shipping_address_id')) {
            $shippingAddress = ShippingAddress::where('id', $request->shipping_address_id)
            ->where('user_id', $user->id)
            ->first();
        }

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
    public function store(PurchaseRequest $request)
    {
        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $baseId = null;

        // 今回の購入に使う住所データ
        if ($request->filled('shipping_address_id')) {
            $base =ShippingAddress::where('id', $request->shipping_address_id)
            ->where('user_id', $user->id)
            ->firstOrFail();
            $baseId = $base->id;
            $postCode = $base->post_code;
            $address  = $base->address;
            $building = $base->building;
        } else {
            $profile = $user->profile;
            $postCode = $profile->post_code;
            $address   = $profile->address;
            $building  = $profile->building;
        }

        //purchases に紐づける
        $purchase = Purchase::create([
        'buyer_user_id' => $user->id,
        'seller_user_id' => $product->user_id,
        'product_id' => $product->id,
        'shipping_address_id' => $baseId,
        'shipping_post_code' => $postCode,
        'shipping_address' => $address,
        'shipping_building' => $building,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
        ]);
        if ($request->payment_method === 'card') {
            // Stripe にリダイレクト
            return redirect()->route('home');
        } else {
            // 一覧に戻す
            return redirect()
            ->route('home')
            ->with('message', 'コンビニでお支払いください');
        }
    }
    public function create(AddressRequest $request,$item_id)
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
        return redirect()->route('purchase.show', [
            'item_id' => $product->id,
            'shipping_address_id' => $shipping->id,
            ]);
    }
}
