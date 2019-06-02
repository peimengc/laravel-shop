<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->comment('优惠卷类型，固定金额、百分比');
            $table->decimal('value')->comment('金额、百分比');
            $table->unsignedInteger('total')->comment('优惠券数量');
            $table->unsignedInteger('used')->default(0)->comment('已用数量');
            $table->decimal('min_amount', 10, 2)->comment('使用金额限制');
            $table->datetime('not_before')->nullable()->comment('使用时间区间');
            $table->datetime('not_after')->nullable()->comment('使用时间区间');
            $table->boolean('enabled')->comment('是否启用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_codes');
    }
}
