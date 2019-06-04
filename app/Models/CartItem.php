<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CartItem
 *
 * @property int $id
 * @property int $uid
 * @property int $psid
 * @property int $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ProductSku $productSku
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem wherePsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
