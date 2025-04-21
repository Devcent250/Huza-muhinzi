<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'total_price',
        'status',
        'notes',
    ];

    // Order statuses
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the product associated with the order.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_ACCEPTED => 'info',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'secondary',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAccepted()
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeAccepted()
    {
        return $this->isPending() && $this->product->isAvailable();
    }

    public function canBeRejected()
    {
        return $this->isPending();
    }

    public function canBeCompleted()
    {
        return $this->isAccepted();
    }

    public function canBeCancelled()
    {
        return $this->isPending() || $this->isAccepted();
    }
}
