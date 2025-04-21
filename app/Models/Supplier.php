<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'description',
        'business_type',
        'location',
        'preferred_categories',
        'is_verified',
        'total_purchases',
        'rating',
    ];

    protected $casts = [
        'preferred_categories' => 'array',
        'is_verified' => 'boolean',
        'total_purchases' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
