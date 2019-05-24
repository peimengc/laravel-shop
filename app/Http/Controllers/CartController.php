<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    /**
     * CartController constructor.
     * @param $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(AddCartRequest $request)
    {
        $skuId = $request->get('sku_id');
        $amount = $request->get('amount');

        $cart = $this->cartService->add($skuId, $amount);

        return [
            'data' => $cart
        ];
    }

    public function index(Request $request)
    {

        $cartItems = $this->cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();

        return view('cart.index', compact('cartItems', 'addresses'));
    }

    public function remove(Request $request, ProductSku $sku)
    {
        $this->cartService->remove($sku->id);

        return [];
    }
}
