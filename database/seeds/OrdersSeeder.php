<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory(\App\Models\Order::class,100)->create();
        $faker = app(\Faker\Generator::class);
        // 被购买的商品，用于后面更新商品销量和评分
        $products = collect([]);

        foreach($orders as $order){
            $items = factory(\App\Models\OrderItem::class,random_int(1,3))->create([
                'order_id' => $order->id,
                'rating' => $order->reviewed ? random_int(1,5) : null,
                'review' => $order->reviewed ? $faker->sentence : null,
                'reviewed_at' => $order->reviewed ? $faker->dateTimeBetween($order->paid_at) : null,
            ]);

            $total = $items->sum(function (\App\Models\OrderItem $item) {
                return $item->price * $item->amount;
            });

            // 如果有优惠券，则计算优惠后价格
            if ($order->couponCode) {
                $total = $order->couponCode->getAdjustedPrice($total);
            }

            // 更新订单总价
            $order->update([
                'total_amount' => $total,
            ]);

            // 将这笔订单的商品合并到商品集合中
            $products = $products->merge($items->pluck('product'));
        }

        // 根据商品 ID 过滤掉重复的商品
        $products->unique('id')->each(function (\App\Models\Product $product) {
            // 查出该商品的销量、评分、评价数
            $result = \App\Models\OrderItem::query()
                ->where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->whereNotNull('paid_at');
                })
                ->first([
                    \DB::raw('count(*) as review_count'),
                    \DB::raw('avg(rating) as rating'),
                    \DB::raw('sum(amount) as sold_count'),
                ]);

            $product->update([
                'rating'       => $result->rating ?: 5, // 如果某个商品没有评分，则默认为 5 分
                'review_count' => $result->review_count,
                'sold_count'   => $result->sold_count,
            ]);
        });
    }
}
