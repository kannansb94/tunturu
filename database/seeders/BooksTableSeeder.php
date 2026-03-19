<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Sustainable Farming',
                'author' => 'Green Earth',
                'description' => 'A guide to eco-friendly agriculture.',
                'selling_price' => 450.00,
                'rental_price' => 50.00,
                'status' => 'available',
                'category' => 'Agriculture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Literacy 101',
                'author' => 'Tech For All',
                'description' => 'Basic computer skills for everyone.',
                'selling_price' => 350.00,
                'rental_price' => 40.00,
                'status' => 'available',
                'category' => 'Education',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Women in Leadership',
                'author' => 'Empower Her',
                'description' => 'Inspiring stories of rural women leaders.',
                'selling_price' => 500.00,
                'rental_price' => 60.00,
                'status' => 'available',
                'category' => 'Empowerment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Healthy Living',
                'author' => 'Dr. A. Smith',
                'description' => 'Nutrition and hygiene basics.',
                'selling_price' => 250.00,
                'rental_price' => 30.00,
                'status' => 'available',
                'category' => 'Health',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
