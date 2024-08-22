<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id',
        'product_id',
        'quantity',
        'unit_amount',
        'total_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
