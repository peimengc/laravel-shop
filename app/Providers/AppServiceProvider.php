<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Yansongda\Pay\Pay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        //往服务器中注入一个名为alipay的单例
        $this->app->singleton('alipay', function () {
            $config = config('pay.alipay');
            $config['notify_url'] = 'http://f42f801b.ngrok.io/payment/alipay/notify';
            $config['return_url'] = route('payment.alipay.return');
            if ($this->app->environment() !== 'production') {
                $config['mode'] = 'dev';
                $config['log']['level'] = 'debug';
            } else {
                $config['log']['level'] = 'info';
            }

            return Pay::alipay($config);
        });

        //注册wechat_pay
        $this->app->singleton('wechat_pay', function () {
            $config = config('pay.wechat');
            if (app()->environment() !== 'production') {
                $config['log']['level'] = 'debug';
            } else {
                $config['log']['level'] = 'info';
            }

            return Pay::wechat($config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
