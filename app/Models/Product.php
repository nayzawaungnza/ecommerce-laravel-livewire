<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'images',
        'description',
        'short_description',
        'is_active',
        'price',
        'quantity',
        'sizes', 'colors', 'sku', 'weight', 'dimensions',
        'is_featured',
        'in_stock',
        'on_sale',
        'category_id',
        'brand_id',
    ];
    protected $cast = [
        'images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function setSizesAttribute($value)
    {
        if (isset($value) && is_array($value)) {
            $this->attributes['sizes'] = json_encode($value);
        } else {
            $this->attributes['sizes'] = $value;
        }
    }

    // Mutator method to handle 'colors' attribute
    public function setColorsAttribute($value)
    {
        if (isset($value) && is_array($value)) {
            $this->attributes['colors'] = json_encode($value);
        } else {
            $this->attributes['colors'] = $value;
        }
    }

    public function setImagesAttribute($value)
    {
        if (isset($value) && is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } else {
            $this->attributes['images'] = $value;
        }
    }

    public function getColorsAttribute($value)
    {
        return json_decode($value, true); // Decode JSON string to array
    }

    public function getSizesAttribute($value)
    {
        return json_decode($value, true); // Decode JSON string to array
    }

    public function getImagesAttribute($value)
    {
        if ($value === null) {
            return [];
        }
        return json_decode($value, true);
    }
}
