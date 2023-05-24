<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'price', 'description', 'qty', 'slug'
    ];

    public function gallery(): HasMany
    {
        return $this->hasMany(products_gallery::class, 'product_id', 'id');
    }

    public function carts(): HasOne
    {
        return $this->hasOne(carts::class, 'product_id', 'id');
    }

    public function transaction_item(): BelongsTo
    {
        return $this->belongsTo(transactionItems::class, 'id', 'product_id');
    }
}
