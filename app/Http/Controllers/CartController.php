<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(AddCartRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $skuId = $request->get('sku_id');
        $amount = $request->get('amount');

        //是否已经加入购物车
        if ($cart = $user->cartItems()->where('psid', $skuId)->first()) {
            $cart->update([
                'amount' => $cart->amount + $amount,
            ]);
        } else {
            $cart = new CartItem(['amount'=>$amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }

        return [];
    }

    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('productSku.product')->get();

        return view('cart.index',compact('cartItems'));
    }

    public function remove(Request $request,$cart_id)
    {
        $request->user()->cartItems()->where('id', $cart_id)->delete();

        return [];
    }
}
