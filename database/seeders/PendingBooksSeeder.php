<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class PendingBooksSeeder extends Seeder
{
    public function run()
    {
        $user = \App\Models\User::first();

        Book::create([
            'title' => 'The Clean Coder (Donation Pending)',
            'author' => 'Robert C. Martin',
            'isbn' => '9780137081073',
            'category' => 'Technology',
            'description' => 'A user wants to donate this book.',
            'type' => 'rent',
            'status' => 'pending_approval',
            'quantity' => 1,
            'rental_price' => 50,
            'selling_price' => 0,
            'donated_by' => $user ? $user->id : null,
        ]);

        Book::create([
            'title' => 'Refactoring (Donation Pending)',
            'author' => 'Martin Fowler',
            'isbn' => '9780201485677',
            'category' => 'Technology',
            'description' => 'Another pending donation.',
            'type' => 'both',
            'status' => 'pending_approval',
            'quantity' => 1,
            'rental_price' => 60,
            'selling_price' => 400,
            'donated_by' => $user ? $user->id : null,
        ]);
    }
}
