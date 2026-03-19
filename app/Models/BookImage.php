<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this line
use App\Models\Book; // Added this line for the relationship

class BookImage extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'image_path'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
