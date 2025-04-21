<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'unit',
        'category',
        'farmer_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Allowed product categories
    const CATEGORIES = [
        'irish_potatoes' => 'Irish Potatoes',
        'maize' => 'Maize',
        'beans' => 'Beans',
    ];

    // Product statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_PENDING = 'pending';
    const STATUS_SOLD = 'sold';

    /**
     * Get the user that owns the product.
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    /**
     * Get the orders for the product.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function markAsPending()
    {
        $this->status = self::STATUS_PENDING;
        $this->save();
    }

    public function markAsSold()
    {
        $this->status = self::STATUS_SOLD;
        $this->save();
    }
}
