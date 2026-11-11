<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountModel extends Model
{
    protected $table = 'discount';
    protected $fillable = [
        'product_id',
        'qty',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
