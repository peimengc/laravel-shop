<?php

Auth::routes(['verify' => true]);

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')
    ->name('products.show')
    ->where(['product'=>'[0-9]+']);

// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::resource('user_addresses', 'UserAddressesController');

    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

    Route::get('orders','OrdersController@index')->name('orders.index');
    Route::post('orders','OrdersController@store')->name('orders.store');
    Route::get('orders/{order}','OrdersController@show')->name('orders.show');
    //确认收货
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
    //评价
    Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
    Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
    //退款
    Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');

    //订单支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    //支付宝前端回调
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');

    //优惠卷
    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');

});
//支付宝服务端回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');