<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\ProductSku;
use App\Models\UserAddress;
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

    public function store(OrderRequest $request)
    {
        //多个数据库操作 使用事务
        $order = \DB::transaction(function () use ($request) {
            $user = $request->user();
            //获取地址
            $address = UserAddress::query()->findOrFail($request->get('address_id'));
            //更新地址最后使用时间
            $address->update(['last_used_at' => Carbon::now()]);
            //创建订单
            $order = new Order([
                'address' => [ // 将地址信息放入订单中
                    'address' => $address->full_address,
                    'zip' => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark' => $request->input('remark'),
                'total_amount' => 0,
            ]);
            //订单关联用户
            $order->user()->associate($user);
            //保存
            $order->save();

            //创建订单items 并计算总价
            $totalAmount = 0;
            $items = $request->input('items');
            // 遍历用户提交的 SKU
            foreach ($items as $data) {
                $sku = ProductSku::find($data['sku_id']);
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price' => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price * $data['amount'];
                //减库存
                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new InvalidRequestException('该商品库存不足');
                }
            }
            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);
            //购物车移除已购买的
            $skuIds = collect($items)->pluck('sku_id');
            $user->cartItems()->whereIn('psid', $skuIds)->delete();

            return $order;
        });

        CloseOrder::dispatch($order)->delay(config('app.order_ttl'));

        return $order;

    }
}
