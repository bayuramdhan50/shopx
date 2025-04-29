<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Encryptable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'encrypted_specs',
        'price',
        'stock',
        'image',
        'featured',
        'category_id',
        'brand',
        'sku',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'featured' => 'boolean',
    ];

    /**
     * The attributes that should be encrypted.
     *
     * @var array<string>
     */
    protected $encryptable = [
        'encrypted_specs',
    ];

    /**
     * Get the order items for this product
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get the category this product belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for this product
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
