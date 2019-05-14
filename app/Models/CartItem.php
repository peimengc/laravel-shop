<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['amount'];

    public $timestamps = false;

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class,'uid');
    }

    public function productSku() :BelongsTo
    {
        return $this->belongsTo(ProductSku::class,'psid');
    }
}
