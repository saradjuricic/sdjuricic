<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'catalog'])->name('products.catalog');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// IMPORTANT: Add dashboard route BEFORE auth.php
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Load Laravel Breeze auth routes
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Cart/order routes
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'viewCart'])->name('cart.index');
    Route::patch('/cart/update', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{productId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'placeOrder'])->name('cart.place-order');
    Route::post('/buy-now/{product}', [App\Http\Controllers\CartController::class, 'buyNow'])->name('product.buy-now');
    Route::get('/order-success/{order}', [App\Http\Controllers\CartController::class, 'orderSuccess'])->name('order.success');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
});