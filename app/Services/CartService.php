<?php

namespace App\Services;

use App\Models\CartItem;
use Auth;


class CartService
{
    public function get()
    {
        return Auth::user()->cartItems()->with(['productSku.product'])->get();
    }

    public function add($skuId, $amount)
    {
        $user = Auth::user();
        //是否已经加入购物车
        if ($cart = $user->cartItems()->where('psid', $skuId)->first()) {
            $cart->update([
                'amount' => $cart->amount + $amount,
            ]);
        } else {
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return $cart;
    }

    public function remove($ids)
    {
        // 可以传单个 ID，也可以传 ID 数组
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        Auth::user()->cartItems()->whereIn('psid', $ids)->delete();
    }
}