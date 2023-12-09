<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Auth;


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
    return view('landing-page');
});
// Route::get('/', [DashboardController::class, 'index_user']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index_user'])->name('home');
Route::get('/books', [UserController::class, 'index'])->name('user.daftar-buku');
Route::get('/books/{id}', [BooksController::class, 'show'])->name('user.details-buku');

//ADMIN
Route::get('/admin/home', [App\Http\Controllers\DashboardController::class, 'index_admin'])->name('admin-home')->middleware('role');
Route::get('/data-buku', [AdminController::class, 'show_books'])->name('admin.data-buku')->middleware('can:isAdmin');
Route::get('/data-author', [AdminController::class, 'show_author'])->name('admin.data-author')->middleware('can:isAdmin');
Route::get('/data-category', [AdminController::class, 'show_category'])->name('admin.data-category')->middleware('can:isAdmin');

Route::delete('/data-buku/{books}', [AdminController::class, 'destroy_books'])->name('books.destroy');
Route::delete('/data-author/{user}', [AdminController::class, 'destroy_author'])->name('author.destroy');
Route::delete('/data-category/{books}', [AdminController::class, 'destroy_category'])->name('category.destroy');
//BOOKS
Route::get('/data-buku/create', [AdminController::class, 'index_create_books'])->name('books-create');
Route::resource('/data-edit',AdminController::class);
Route::post('/add-books', [AdminController::class, 'store_books2'])->name('books.store2');
Route::get('/data-buku/{id}/edit', [AdminController::class, 'edit_books'])->name('books.edit');
Route::put('/data-buku/{id}', [AdminController::class, 'update_books'])->name('data-books.update');
//AUTHOR
Route::get('/data-author/create', [AdminController::class, 'index_create_author'])->name('author-create');
Route::get('/data-author/create', [AdminController::class, 'index_create_author'])->name('author-create');
Route::post('/add-author', [AdminController::class, 'store_author'])->name('author.store');
Route::get('/data-author/{id}/edit', [AdminController::class, 'edit_author'])->name('author.edit');
Route::put('/data-author/{id}', [AdminController::class, 'update_author'])->name('data-author.update');
//CATEGORY
Route::get('/data-category/create', [AdminController::class, 'index_create_category'])->name('category-create');
Route::get('/data-category/create', [AdminController::class, 'index_create_category'])->name('category-create');
Route::post('/add-category', [AdminController::class, 'store_category'])->name('category.store');
Route::get('/data-category/{id}/edit', [AdminController::class, 'edit_category'])->name('category.edit');
Route::put('/data-category/{id}', [AdminController::class, 'update_category'])->name('data-category.update');
