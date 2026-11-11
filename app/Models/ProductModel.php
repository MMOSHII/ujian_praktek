<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function discountRelation()
    {
        return $this->hasOne(DiscountModel::class, 'product_id');
    }

    public function getFinalPriceAttribute()
    {
        $discountPercent = $this->discountRelation?->discount ?? 0;
        if ($discountPercent > 0) {
            $discountAmount = $this->price * ($discountPercent / 100);
            return max(0, round($this->price - $discountAmount));
        }
        return $this->price;
    }
}
