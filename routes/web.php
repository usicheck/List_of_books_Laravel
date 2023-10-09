<?php

use App\Http\Controllers\AuthorsController;
use App\Models\Author;
use Illuminate\Support\Facades\Route;

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


Route::get('/', ['App\Http\Controllers\HomeController', 'index'])->name('home');


Route::get('/books/{id}', [\App\Http\Controllers\BooksController::class, 'show'])->name('books.show');
Route::get('/books', [\App\Http\Controllers\BooksController::class, 'index'])->name('books.index');
Route::post('/books/store', [\App\Http\Controllers\BooksController::class, 'store'])->name('books.store');
Route::put('/books/update/{id}', [\App\Http\Controllers\BooksController::class, 'update'])->name('books.update');

Route::delete('/books/delete/{id}', [\App\Http\Controllers\BooksController::class, 'delete'])->name('books.delete');


Route::get('/authors', [\App\Http\Controllers\AuthorsController::class, 'index'])->name('authors.index');
Route::post('/authors/store', [\App\Http\Controllers\AuthorsController::class, 'store'])->name('authors.store');
Route::put('/authors/update/{id}', [\App\Http\Controllers\AuthorsController::class, 'update'])->name('authors.update');
Route::delete('ajax/authors/{id}', \App\Http\Controllers\Ajax\RemoveAuthorController::class)->name('ajax.authors.delete');




