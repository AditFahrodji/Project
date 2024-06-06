<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\PasswordPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\KategoriPage;
use App\Livewire\KeranjangPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrderPage;
use App\Livewire\ProdukDetailPage;
use App\Livewire\ProdukPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/kategori', KategoriPage::class);
Route::get('/produk', ProdukPage::class);
Route::get('/keranjang', KeranjangPage::class);
Route::get('/produk/{slug}', ProdukDetailPage::class);


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', PasswordPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
});


Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    });
    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-order', MyOrderPage::class);
    Route::get('/my-order/{order}', MyOrderDetailPage::class);
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
});