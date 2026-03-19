<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'isbn',
        'cover_image',
        'status',
        'selling_price',
        'rental_price',
        'quantity',
        'category',
        'language',
        'type',
        'donated_by',
        'approved_by',
        'approved_at',
        'rejected_at',
        'donor_location',
        'rental_duration_days',
        'late_fee_per_day',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name'); // Assuming category is stored as name for now, or just returns the string
    }

    public function images()
    {
        return $this->hasMany(BookImage::class);
    }
    public function donor()
    {
        return $this->belongsTo(User::class, 'donated_by');
    }

    // Relationship for approver
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
