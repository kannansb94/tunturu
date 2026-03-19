<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Response;

class BulkUploadController extends Controller
{
    public function index()
    {
        return view('library.admin.bulk.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        // Open file
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            // Get header
            $header = fgetcsv($handle, 1000, ',');

            // Expected columns
            $expected = ['title', 'author', 'isbn', 'description', 'selling_price', 'rental_price', 'quantity', 'category', 'type', 'status'];

            // Basic header validation (optional, can be stricter)

            $row = 1;
            $successCount = 0;
            $errors = [];

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $row++;
                try {
                    // Map data to columns based on index (assuming fixed order for simplicity)
                    // 0: title, 1: author, 2: isbn, 3: description, 4: selling_price, 5: rental_price, 6: quantity, 7: category, 8: type, 9: status

                    if (count($data) < 10) {
                        $errors[] = "Row $row: Insufficient columns";
                        continue;
                    }

                    // Map CSV values to Enum values
                    $type = strtolower($data[8]);
                    if ($type === 'sell')
                        $type = 'sale';
                    if ($type === 'rental')
                        $type = 'rent';

                    // Validate enum
                    if (!in_array($type, ['rent', 'sale', 'both'])) {
                        $errors[] = "Row $row: Invalid type '$type'. Must be 'rent', 'sell' (or 'sale'), or 'both'.";
                        continue;
                    }

                    Book::create([
                        'title' => $data[0],
                        'author' => $data[1],
                        'isbn' => $data[2],
                        'description' => $data[3],
                        'selling_price' => $data[4],
                        'rental_price' => $data[5],
                        'quantity' => $data[6],
                        'category' => $data[7], // Assuming category name string store
                        'type' => $type,
                        'status' => strtolower($data[9]) ?: 'available',
                        'rental_duration_days' => 7, // Default
                        'late_fee_per_day' => 10, // Default
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row $row: " . $e->getMessage();
                }
            }
            fclose($handle);

            if (count($errors) > 0) {
                return redirect()->back()->with('success', "$successCount books uploaded successfully")->with('errors_list', $errors);
            }

            return redirect()->back()->with('success', "$successCount books uploaded successfully!");
        }

        return redirect()->back()->with('error', "Failed to open file");
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="books_template.csv"',
        ];

        $columns = ['Title', 'Author', 'ISBN', 'Description', 'Selling Price', 'Rental Price', 'Quantity', 'Category', 'Type (rent/sell/both)', 'Status'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            // Example row
            fputcsv($file, ['Sample Book', 'John Doe', '978-3-16-148410-0', 'Valid description', '500', '50', '10', 'Fiction', 'both', 'available']);
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
