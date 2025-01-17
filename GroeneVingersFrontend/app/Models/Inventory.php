<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'quantity',
    ];

    protected $attributes = [
        'quantity' => 0, // Specify default value for quantity attribute
    ];

    // Define relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
