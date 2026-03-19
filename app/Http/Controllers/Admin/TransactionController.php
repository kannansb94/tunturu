<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Transaction::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $transactions = $query->latest()->paginate(15);
        return view('library.admin.transactions.index', compact('transactions'));
    }
}
