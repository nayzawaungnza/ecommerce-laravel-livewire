<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\CategoriesPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('homePageRoute');
Route::get('categories', CategoriesPage::class)->name('categoriesRoute');
Route::get('products', ProductsPage::class)->name('productsRoute');
Route::get('cart', CartPage::class)->name('cartRoute');
Route::get('products/{slug}', ProductDetailPage::class)->name('productDetailRoute');


Route::middleware('guest')->group(function () {
    Route::get('login', LoginPage::class)->name('login');
    Route::get('register', RegisterPage::class)->name('registerRoute');
    Route::get('forgot-password', ForgotPasswordPage::class)->name('password.request');
    Route::get('reset/password/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logoutRoute');
    Route::get('checkout', CheckoutPage::class)->name('checkoutRoute');
    Route::get('my-orders', MyOrdersPage::class)->name('myOrdersRoute');
    Route::get('my-orders/{order_id}', MyOrderDetailPage::class)->name('my-orders.show');
    Route::get('success', SuccessPage::class)->name('successRoute');
    Route::get('cancel', CancelPage::class)->name('cancelRoute');
});
