<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController; // Assuming this might be needed if referenced
use App\Http\Controllers\CooperativeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\FarmerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'cooperative_member':
            return redirect()->route('cooperative.dashboard');
        case 'supplier':
            return redirect()->route('supplier.dashboard');
        case 'farmer':
            return redirect()->route('farmer.dashboard');
        default:
            return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Review routes
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // Add other admin-specific routes here
    });

    // Cooperative routes
    Route::middleware('role:cooperative_member')->prefix('cooperative')->name('cooperative.')->group(function () {
        Route::get('/dashboard', [CooperativeController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    });

    // Supplier routes
    Route::middleware('role:supplier')->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/dashboard', [SupplierController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::resource('orders', OrderController::class)->only(['show', 'update']);
        Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });
});

require __DIR__ . '/auth.php';

// Farmer Routes
Route::middleware(['auth', 'verified', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');

    // Product routes
    Route::get('/products/create', [FarmerController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [FarmerController::class, 'storeProduct'])->name('products.store');
    Route::get('/products', [FarmerController::class, 'products'])->name('products.index');

    // Request routes
    Route::get('/requests', [FarmerController::class, 'requests'])->name('requests.index');
    Route::get('/requests/{order}', [FarmerController::class, 'showRequest'])->name('requests.show');
    Route::post('/requests/{order}/respond', [FarmerController::class, 'respondToRequest'])->name('requests.respond');

    // Order routes
    Route::get('/orders', [FarmerController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [FarmerController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/update', [FarmerController::class, 'updateOrder'])->name('orders.update');
});
