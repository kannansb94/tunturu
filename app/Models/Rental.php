<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'rental_date',
        'expected_return_date',
        'actual_return_date',
        'rental_price',
        'late_fee',
        'total_amount',
        'status',
        'payment_status',
        'delivery_status',
        'delivery_name',
        'delivery_phone',
        'delivery_address',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'expected_return_date' => 'date',
        'actual_return_date' => 'date',
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getDaysOverdueAttribute()
    {
        if ($this->status === 'returned') {
            return 0;
        }

        $compareDate = $this->actual_return_date ?? now();

        if ($compareDate->gt($this->expected_return_date)) {
            return $compareDate->diffInDays($this->expected_return_date);
        }

        return 0;
    }

    public function getCalculatedLateFeeAttribute()
    {
        if ($this->days_overdue > 0 && $this->book) {
            return $this->days_overdue * $this->book->late_fee_per_day;
        }

        return 0;
    }

    public function getIsOverdueAttribute()
    {
        return $this->status !== 'returned' && now()->gt($this->expected_return_date);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'returned')
            ->whereDate('expected_return_date', '<', now());
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }
}
