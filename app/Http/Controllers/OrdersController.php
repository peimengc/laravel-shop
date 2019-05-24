<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Services\CartService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['items.product', 'items.productSku'])
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user = $request->user();
        /** @var UserAddress $address */
        $address = UserAddress::query()->findOrFail($request->get('address_id'));

        return $orderService->add($user, $address, $request->get('remark'), $request->get('items'));

    }
}
