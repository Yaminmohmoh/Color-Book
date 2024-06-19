<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeContoller::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Admin Route
Route::get('/home', [AdminController::class, 'index']);
Route::get('/category_page', [AdminController::class, 'CategoryPage']);
Route::Post('/add_category', [AdminController::class, 'AddCategory']);
Route::get('/cart_delete/{id}', [AdminController::class, 'DeleteCart']);
Route::get('/edit_category/{id}', [AdminController::class, 'EditCategory']);
Route::post('/update_category/{id}', [AdminController::class, 'UpdateCategory']);
Route::get('/add_book', [AdminController::class, 'AddBooks']);
Route::post('/store_book', [AdminController::class, 'StoreBooks']);
