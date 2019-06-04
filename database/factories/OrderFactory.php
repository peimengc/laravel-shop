<?php

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Order;
use App\Models\CouponCode;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $user = User::query()->inRandomOrder()->first();
    $userAddress = $user->addresses()->inRandomOrder()->first();
    // 10% 的概率把订单标记为退款
    $refund = random_int(0, 10) < 1;
    // 随机生成发货状态
    $ship = $refund ? Order::SHIP_STATUS_RECEIVED :$faker->randomElement(array_keys(Order::$shipStatusMap));
    //优惠卷
    $coupon = null;
    //使用优惠卷 30%几率
    if (random_int(0, 10) < 3) {
        $coupon = CouponCode::query()->inRandomOrder()->first();
        //增加使用量
        $coupon->changeUsed();
    }


    return [
        'address'        => [
            'address'       => $userAddress->full_address,
            'zip'           => $userAddress->zip,
            'contact_name'  => $userAddress->contact_name,
            'contact_phone' => $userAddress->contact_phone,
        ],
        'total_amount'   => 0,
        'remark'         => $faker->sentence,
        'paid_at'        => $faker->dateTimeBetween('-30 days'), // 30天前到现在任意时间点
        'payment_method' => $faker->randomElement(['wechat', 'alipay']),
        'payment_no'     => $faker->uuid,
        'refund_status'  => $refund ? Order::REFUND_STATUS_SUCCESS : Order::REFUND_STATUS_PENDING,
        'refund_no'      => $refund ? Order::getAvailableRefundNo() : null,
        'closed'         => false,
        'reviewed'       => random_int(0, 10) > 2,
        'ship_status'    => $ship,
        'ship_data'      => $ship === Order::SHIP_STATUS_PENDING ? null : [
            'express_company' => $faker->company,
            'express_no'      => $faker->uuid,
        ],
        'extra'          => $refund ? ['refund_reason' => $faker->sentence] : [],
        'user_id'        => $user->id,
        'coupon_code_id' => $coupon ? $coupon->id : null,
    ];
});
