<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Rental;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base Queries
        $salesQuery = Sale::query()->where('payment_status', 'completed');
        $rentalsQuery = Rental::query()->where('payment_status', 'paid');

        if ($startDate && $endDate) {
            $salesQuery->whereBetween('sale_date', [$startDate, $endDate]);
            $rentalsQuery->whereBetween('rental_date', [$startDate, $endDate]);
        }

        // 1. Dashboard Summary Metrics
        $totalSalesRevenue = $salesQuery->sum('total_amount');
        $totalRentalRevenue = $rentalsQuery->sum('total_amount');
        // For active rentals, we might want to include potential late fees, but let's stick to 'total_amount' column which should be updated on return
        // Now filtered by 'paid' status.

        $totalRevenue = $totalSalesRevenue + $totalRentalRevenue;

        $activeRentalsCount = Rental::active()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('rental_date', [$startDate, $endDate]);
            })
            ->count();

        $overdueRentalsCount = Rental::where('status', 'active')
            ->where('expected_return_date', '<', now())
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('rental_date', [$startDate, $endDate]);
            })
            ->count();

        $booksSold = $salesQuery->sum('quantity');

        // 2. Revenue Chart Data
        // If filtered, show daily data if <= 31 days, otherwise monthly (or just fit the range)
        $months = [];
        $salesData = [];
        $rentalData = [];

        if ($startDate && $endDate) {
            // Custom Range Logic (Daily breakdown)
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $diffInDays = $start->diffInDays($end);

            if ($diffInDays <= 31) {
                // Daily
                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $months[] = $date->format('M d');
                    $salesData[] = Sale::whereDate('sale_date', $date)->where('payment_status', 'completed')->sum('total_amount');
                    $rentalData[] = Rental::whereDate('rental_date', $date)->where('payment_status', 'paid')->sum('total_amount');
                }
            } else {
                // Monthly (within range)
                $current = $start->copy()->startOfMonth();
                $endMonth = $end->copy()->endOfMonth();

                while ($current->lte($endMonth)) {
                    $months[] = $current->format('M Y');
                    $salesData[] = Sale::whereYear('sale_date', $current->year)
                        ->whereMonth('sale_date', $current->month)
                        ->where('payment_status', 'completed')
                        ->sum('total_amount');
                    $rentalData[] = Rental::whereYear('rental_date', $current->year)
                        ->whereMonth('rental_date', $current->month)
                        ->where('payment_status', 'paid')
                        ->sum('total_amount');
                    $current->addMonth();
                }
            }
        } else {
            // Default: Last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthName = $date->format('M Y');
                $year = $date->year;
                $month = $date->month;

                $months[] = $monthName;

                $salesData[] = Sale::whereYear('sale_date', $year)
                    ->whereMonth('sale_date', $month)
                    ->where('payment_status', 'completed')
                    ->sum('total_amount');

                $rentalData[] = Rental::whereYear('rental_date', $year)
                    ->whereMonth('rental_date', $month)
                    ->where('payment_status', 'paid')
                    ->sum('total_amount');
            }
        }

        // 3. Rental Status Distribution (Snapshot - usually doesn't make sense to filter by historical date range for CURRENT status, 
        // but we can filter by "Rentals created in this range" and their CURRENT status)
        $rentalStatusQuery = Rental::query();
        if ($startDate && $endDate) {
            $rentalStatusQuery->whereBetween('rental_date', [$startDate, $endDate]);
        }

        $rentalStatusData = [
            (clone $rentalStatusQuery)->where('status', 'active')->where('expected_return_date', '>=', now())->count(),
            (clone $rentalStatusQuery)->where('status', 'active')->where('expected_return_date', '<', now())->count(),
            (clone $rentalStatusQuery)->where('status', 'returned')->count(),
        ];

        // 4. Recent Activity
        $recentSales = $salesQuery->with(['book', 'user'])->latest()->take(10)->get();
        $recentRentals = $rentalsQuery->with(['book', 'user'])->latest()->take(10)->get();

        // Merge and sort by date for a combined feed (optional, or just pass both)
        // Let's pass both for separate sections

        return view('library.admin.reports.index', compact(
            'totalRevenue',
            'totalSalesRevenue',
            'totalRentalRevenue',
            'activeRentalsCount',
            'overdueRentalsCount',
            'booksSold',
            'months',
            'salesData',
            'rentalData',
            'rentalStatusData',
            'recentSales',
            'recentRentals'
        ));
    }
    public function export(Request $request)
    {
        $type = $request->query('type', 'sales'); // 'sales' or 'rentals'
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = $type . '_report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            if ($type === 'sales') {
                // Header Row
                fputcsv($file, ['Order ID', 'Date', 'Book Title', 'Customer Name', 'Email', 'Quantity', 'Amount (INR)', 'Payment Method', 'Status']);

                // Data Rows
                $query = Sale::query()->with(['book', 'user'])->where('payment_status', 'completed');
                if ($startDate && $endDate) {
                    $query->whereBetween('sale_date', [$startDate, $endDate]);
                }

                $query->chunk(100, function ($sales) use ($file) {
                    foreach ($sales as $sale) {
                        fputcsv($file, [
                            $sale->id,
                            $sale->sale_date->format('Y-m-d H:i:s'),
                            $sale->book->title,
                            $sale->user->name,
                            $sale->user->email,
                            $sale->quantity,
                            $sale->total_amount,
                            ucfirst($sale->payment_method),
                            ucfirst($sale->delivery_status)
                        ]);
                    }
                });
            } elseif ($type === 'rentals') {
                // Header Row
                fputcsv($file, ['Rental ID', 'Date', 'Book Title', 'Customer Name', 'Email', 'Due Date', 'Return Date', 'Fee (INR)', 'Status']);

                // Data Rows
                $query = Rental::query()->with(['book', 'user'])->where('payment_status', 'paid');
                if ($startDate && $endDate) {
                    $query->whereBetween('rental_date', [$startDate, $endDate]);
                }

                $query->chunk(100, function ($rentals) use ($file) {
                    foreach ($rentals as $rental) {
                        fputcsv($file, [
                            $rental->id,
                            $rental->rental_date->format('Y-m-d H:i:s'),
                            $rental->book->title,
                            $rental->user->name,
                            $rental->user->email,
                            $rental->expected_return_date ? $rental->expected_return_date->format('Y-m-d') : 'N/A',
                            $rental->actual_return_date ? $rental->actual_return_date->format('Y-m-d') : 'Not Returned',
                            $rental->total_amount,
                            ucfirst($rental->status)
                        ]);
                    }
                });
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
