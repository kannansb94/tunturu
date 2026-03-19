<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'sale_date',
        'quantity',
        'price_per_unit',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'delivery_status',
        'delivery_name',
        'delivery_phone',
        'delivery_address',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
