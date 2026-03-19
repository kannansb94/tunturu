<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\KYCController;
use App\Http\Controllers\User\DonationController as UserDonationController;




Route::get('/debug-roles', function () {
    return \App\Models\Role::all();
});

Route::get('/fix-role-force', function () {
    $user = auth()->user();
    // Force find Editor role by name if slug fails?
    $editorRole = \App\Models\Role::where('slug', 'editor')->orWhere('name', 'Editor')->first();

    if ($editorRole) {
        $user->role_id = $editorRole->id;
        $user->role = 'editor'; // Ensure column matches
        $user->save();
        return "Forced Editor Role! Updated role_id to {$editorRole->id} ({$editorRole->name}). ID: {$user->id}";
    }

    return "Could not find Editor role in DB.";
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        // Redirect to the correct panel URL based on role
        $role = $user->role_relation ? $user->role_relation->slug : $user->role;
        return redirect()->route('library.admin.index', ['panel_role' => $role]);
    }
    return redirect()->route('library.user');
})->middleware(['auth', 'verify.otp'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/document/{type}', [KYCController::class, 'showDocument'])->name('profile.document');
    Route::post('/kyc', [App\Http\Controllers\KYCController::class, 'store'])->name('kyc.store');
});

Route::group(['prefix' => 'library', 'as' => 'library.'], function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index');
    Route::get('/book/{category}/{slug}', [LibraryController::class, 'show'])->name('book.show');

    Route::middleware(['auth', 'verify.otp'])->group(function () {
        Route::get('/user', [LibraryController::class, 'user'])->name('user');

        // User Donation Routes
        Route::get('/donate', [UserDonationController::class, 'create'])->name('user.donate');
        Route::post('/donate', [UserDonationController::class, 'store'])->name('user.donate.store');
        Route::get('/donation-status', [UserDonationController::class, 'status'])->name('user.donation.status');

        // User Orders & Rentals Routes
        Route::get('/orders', [LibraryController::class, 'orders'])->name('user.orders');
        Route::get('/rentals', [LibraryController::class, 'rentals'])->name('user.rentals');

        // User Checkout Routes
        Route::get('/cart', [App\Http\Controllers\User\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\User\CartController::class, 'store'])->name('cart.add');
        Route::delete('/cart/{cart}', [App\Http\Controllers\User\CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/checkout', [App\Http\Controllers\User\BookActionController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [App\Http\Controllers\User\BookActionController::class, 'process'])->name('checkout.process');
        Route::post('/checkout/create-razorpay-order', [App\Http\Controllers\User\BookActionController::class, 'createRazorpayOrder'])->name('checkout.create-razorpay-order');
        Route::post('/checkout/verify-payment', [App\Http\Controllers\User\BookActionController::class, 'verifyOnlinePayment'])->name('checkout.verify-payment');
        Route::get('/thank-you', [App\Http\Controllers\User\BookActionController::class, 'thankYou'])->name('thank-you');

        // Admin Routes
        // Changed prefix to {panel_role} to support dynamic URLs like /library/editor, /library/billing
        // Added role.panel middleware to validate and set defaults
        Route::middleware([\App\Http\Middleware\EnsureUserIsAdmin::class, 'role.panel'])
            ->prefix('{panel_role}')
            ->as('admin.')
            ->group(function () {
                Route::get('/', [LibraryController::class, 'admin'])->name('index');

                // Core Modules
                Route::post('books/check-slug', [App\Http\Controllers\Admin\BookController::class, 'checkSlug'])->name('books.checkSlug');

                Route::middleware('can:manage_books')->group(function () {
                    Route::delete('/books/bulk-delete', [App\Http\Controllers\Admin\BookController::class, 'bulkDelete'])->name('books.bulkDelete');
                    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
                    Route::delete('/books/images/{image}', [App\Http\Controllers\Admin\BookController::class, 'destroyImage'])->name('books.images.destroy');
                    Route::get('/bulk-upload', [App\Http\Controllers\Admin\BulkUploadController::class, 'index'])->name('bulk.index');
                    Route::post('/bulk-upload', [App\Http\Controllers\Admin\BulkUploadController::class, 'store'])->name('bulk.store');
                    Route::get('/bulk-upload/template', [App\Http\Controllers\Admin\BulkUploadController::class, 'downloadTemplate'])->name('bulk.template');
                });

                Route::middleware('can:manage_categories')->group(function () {
                    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
                });

                Route::middleware('can:manage_rentals')->group(function () {
                    Route::resource('rentals', App\Http\Controllers\Admin\RentalController::class);
                    Route::patch('/rentals/{rental}/mark-returned', [App\Http\Controllers\Admin\RentalController::class, 'markReturned'])->name('rentals.markReturned');
                    Route::patch('/rentals/{rental}/payment-status', [App\Http\Controllers\Admin\RentalController::class, 'updatePaymentStatus'])->name('rentals.updatePaymentStatus');
                    Route::patch('/rentals/{rental}/delivery-status', [App\Http\Controllers\Admin\RentalController::class, 'updateDeliveryStatus'])->name('rentals.updateDeliveryStatus');
                });

                Route::middleware('can:manage_sales')->group(function () {
                    Route::patch('/sales/{sale}/status', [App\Http\Controllers\Admin\SalesController::class, 'updateStatus'])->name('sales.updateStatus');
                    Route::resource('sales', App\Http\Controllers\Admin\SalesController::class)->except(['create', 'store']);
                    Route::resource('transactions', App\Http\Controllers\Admin\TransactionController::class);
                });

                // Notifications
                Route::get('/notifications/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
                Route::get('/notifications/{id}/mark-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.markRead');

                // Donations - Admin Only (Super Admin via Gate/Permission check)
                Route::middleware('can:manage_donations')->group(function () {
                    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
                    Route::patch('/donations/{book}/approve', [DonationController::class, 'approve'])->name('donations.approve');
                    Route::patch('/donations/{book}/reject', [DonationController::class, 'reject'])->name('donations.reject');
                    Route::get('/donations/status', [DonationController::class, 'status'])->name('donations.status');
                    Route::post('/donations/settings', [DonationController::class, 'updateSettings'])->name('donations.settings.update');
                });

                // Users & KYC - Admin Only
                Route::middleware('can:manage_users')->group(function () {
                    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
                    Route::post('/users', [UserController::class, 'store'])->name('users.store');
                    Route::get('/users', [UserController::class, 'index'])->name('users.index');
                    Route::post('/users/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
                    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->withTrashed();
                    Route::patch('/users/{user}/kyc/approve', [UserController::class, 'approveKYC'])->name('users.kyc.approve');
                    Route::patch('/users/{user}/kyc/reject', [UserController::class, 'rejectKYC'])->name('users.kyc.reject');
                    Route::patch('/users/{user}/kyc/undo-reject', [UserController::class, 'undoRejectKYC'])->name('users.kyc.undo_reject');
                    Route::get('/users/{user}/document/{type}', [UserController::class, 'showDocument'])->name('users.document');
                    
                    // Ban and Delete routes
                    Route::patch('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
                    Route::patch('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban')->withTrashed();
                    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
                    Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
                    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
                });

                Route::middleware('can:view_reports')->group(function () {
                    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
                    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
                });

                Route::middleware('can:manage_settings')->group(function () {
                    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
                    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
                });
            });
    });
});

require __DIR__ . '/auth.php';


Route::get('/debug-url-e2e', function () {
    return [
        'APP_URL' => config('app.url'),
        'url(/)' => url('/'),
        'url(/dashboard)' => url('/dashboard'),
        'route(dashboard)' => route('dashboard'),
        'request_root' => request()->root(),
        'request_uri' => request()->getRequestUri(),
        'start_url_forced' => \Illuminate\Support\Facades\URL::current(),
    ];
});
