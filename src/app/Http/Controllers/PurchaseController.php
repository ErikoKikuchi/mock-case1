<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

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
        $selectedPayment = session("selected_payment_{$item_id}",null);
        $user?->profile;
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
        abort_if($product->isSold(), 403);
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

        if ($request->payment_method === 'card') {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = CheckoutSession::create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->title,
                        ],
                        'unit_amount' => (int) $product->price,
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => route('purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'buyer_user_id' => $user->id,
                    'product_id' => $product->id,
                    'shipping_address_id' => $baseId,
                    'shipping_post_code' => $postCode,
                    'shipping_address' => $address,
                    'shipping_building' => $building,
                    'payment_method' => 'card',
                ],
            ]);
            return redirect($session->url);
        } else {
            Purchase::create([
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
            session()->forget("selected_payment_{$product->id}");
            return redirect()
            ->route('home')
            ->with('message', 'コンビニでお支払いください');
        }
    }
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (Purchase::where('stripe_session_id', $sessionId)->exists()) {
        return redirect()->route('home');
        }
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        abort_unless($session->payment_status === 'paid', 400);
        $md = $session->metadata;

        $exists = Purchase::where('product_id', $md['product_id'] ?? null)
        ->where('buyer_user_id', $md['buyer_user_id'] ?? null)
        ->where('status', 'paid')
        ->exists();

        if (!$exists) {
            $product = Product::findOrFail($md['product_id']);
            $shippingAddressId = null;
            if (isset($md['shipping_address_id']) && $md['shipping_address_id'] !== '' && $md['shipping_address_id'] !== null) {
            $shippingAddressId = (int) $md['shipping_address_id'];
            }

            Purchase::create([
                'buyer_user_id' => (int) $md['buyer_user_id'],
                'seller_user_id' => $product->user_id,
                'product_id' => $product->id,
                'shipping_address_id' => $shippingAddressId,
                'shipping_post_code' => $md['shipping_post_code'],
                'shipping_address' => $md['shipping_address'],
                'shipping_building' => $md['shipping_building'],
                'payment_method' => 'card',
                'status' => 'paid',
                'stripe_session_id' => $sessionId,
            ]);
    }
    session()->forget("selected_payment_{$product->id}");
    return redirect()->route('home');
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
    public function updatePayment(Request $request, $item_id)
    {
    $request->validate([
        'payment_method' => ['required', 'in:card,convenience']
    ]);

    session(["selected_payment_{$item_id}" => $request->payment_method]);

    return response()->json(['status' => 'ok']);
    }
}
