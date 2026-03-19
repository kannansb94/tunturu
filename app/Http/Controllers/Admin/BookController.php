<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\BookImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search by Title, Author, or ISBN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $books = $query->latest()->paginate(10)->withPath(route('library.admin.books.index'))->withQueryString();
        $categories = Category::all();

        return view('library.admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('library.admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'language' => 'nullable|string|max:100',
            'language_other' => 'nullable|string|max:100|required_if:language,Other',
            'type' => 'required|in:rent,sale,both',
            'rental_price' => 'nullable|required_if:type,rent,both|numeric|min:0',
            'rental_duration_days' => 'nullable|required_if:type,rent,both|integer|min:1',
            'late_fee_per_day' => 'nullable|required_if:type,rent,both|numeric|min:0',
            'selling_price' => 'nullable|required_if:type,sale,both|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
            'cover_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'slug' => 'nullable|string|max:255|unique:books,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ], [
            'slug.unique' => 'Already this url is in database, change the url',
        ]);

        // Handle "Other" language option
        if ($request->language === 'Other' && $request->filled('language_other')) {
            $validated['language'] = $request->language_other;
        }

        // Handle Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['category'] . '-' . $validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Add meta fields to creation data
        $validated['meta_title'] = $request->meta_title;
        $validated['meta_description'] = $request->meta_description;
        $validated['meta_keywords'] = $request->meta_keywords;

        // Handle cover image upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Create the book
        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'language' => $validated['language'] ?? null,
            'type' => $validated['type'],
            'rental_price' => $validated['rental_price'] ?? 0,
            'rental_duration_days' => $validated['rental_duration_days'] ?? 7,
            'late_fee_per_day' => $validated['late_fee_per_day'] ?? 5.00,
            'selling_price' => $validated['selling_price'] ?? 0,
            'quantity' => $validated['quantity'],
            'status' => $validated['status'],
            'cover_image' => $coverImagePath,
            'slug' => $validated['slug'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
        ]);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('books/gallery', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('library.admin.books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = \App\Models\Category::all();
        return view('library.admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'category' => 'required|string',
            'language' => 'nullable|string|max:100',
            'language_other' => 'nullable|string|max:100|required_if:language,Other',
            'description' => 'nullable|string',
            'type' => 'required|in:rent,sale,both',
            'selling_price' => 'nullable|required_if:type,sale,both|numeric|min:0',
            'rental_price' => 'nullable|required_if:type,rent,both|numeric|min:0',
            'rental_duration_days' => 'nullable|required_if:type,rent,both|integer|min:1',
            'late_fee_per_day' => 'nullable|required_if:type,rent,both|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:available,rented,sold,lost',
            'slug' => 'nullable|string|max:255|unique:books,slug,' . $book->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ], [
            'slug.unique' => 'Already this url is in database, change the url',
        ]);

        // Handle "Other" language option
        if ($request->language === 'Other' && $request->filled('language_other')) {
            $validated['language'] = $request->language_other;
        }

        // Handle Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['category'] . '-' . $validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Add meta fields
        $validated['meta_title'] = $request->meta_title;
        $validated['meta_description'] = $request->meta_description;
        $validated['meta_keywords'] = $request->meta_keywords;

        if ($request->type === 'rent') {
            $validated['selling_price'] = 0;
        } elseif ($request->type === 'sale') {
            $validated['rental_price'] = 0;
            $validated['rental_duration_days'] = 0;
            $validated['late_fee_per_day'] = 0;
        }

        if (in_array($validated['status'], ['lost', 'unavailable'])) {
            $validated['quantity'] = 0;
        }

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('books/gallery', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('library.admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroyImage(BookImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if (\App\Models\Rental::where('book_id', $book->id)->where('status', 'active')->exists()) {
            return redirect()->back()->with('error', 'Cannot delete a book that has active rentals. Please wait until all copies are returned.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('library.admin.books.index')->with('success', 'Book deleted successfully.');
    }

    /**
     * Remove the specified resources from storage (bulk delete).
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'book_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->book_ids);
        $books = Book::whereIn('id', $ids)->get();

        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($books as $book) {
            if (\App\Models\Rental::where('book_id', $book->id)->where('status', 'active')->exists()) {
                $skippedCount++;
                continue; // Skip books with active rentals
            }

            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->delete();
            $deletedCount++;
        }

        if ($skippedCount > 0) {
            return redirect()->back()->with('success', "{$deletedCount} books deleted successfully. {$skippedCount} rented books were skipped.");
        }

        return redirect()->back()->with('success', 'Selected books deleted successfully.');
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->slug;
        $id = $request->id;

        $query = Book::where('slug', $slug);

        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}
