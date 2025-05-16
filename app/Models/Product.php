<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Attributes that can be mass assigned.
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'image',
        'category_id',
        'is_published',
        'stock_quantity',
        'sku',
    ];

    // Optionally cast price to a float.
    protected $casts = [
        'price' => 'float',
        'is_published' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}

?>
