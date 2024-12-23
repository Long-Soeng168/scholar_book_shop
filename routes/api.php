<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\FooterController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AboutController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\InvoiceController;

Route::post('/orders', [OrderController::class, 'store']);

Route::get('/holds', [InvoiceController::class, 'holds']);
Route::delete('/holds/{id}', [InvoiceController::class, 'delete'])->middleware('auth:sanctum');

Route::post('/invoices', [InvoiceController::class, 'store']);
// ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('publishers', [PublisherController::class, 'publishers']);
Route::get('links', [LinkController::class, 'index']);
Route::get('payments', [PaymentController::class, 'index']);
Route::get('customers', [CustomerController::class, 'index']);
Route::get('authors', [AuthorController::class, 'index']);
Route::get('footer', [FooterController::class, 'index']);
Route::get('slides', [SlideController::class, 'index']);
Route::resource('news', NewsController::class);
Route::get('news_categories', [NewsController::class, 'categories']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories_most_books', [CategoryController::class, 'getCategoryWithMostBooks']);
Route::get('promotions', [PromotionController::class, 'index']);
Route::get('features', [FeatureController::class, 'index']);
Route::get('contact', [ContactController::class, 'index']);
Route::get('about', [AboutController::class, 'index']);
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::get('books_new_arrival', [BookController::class, 'new_arrival']);
Route::get('books_best_selling', [BookController::class, 'best_selling']);
Route::get('kid_books', [BookController::class, 'kid_books']);


// Auth

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/email/verification-notification', [AuthController::class, 'resendEmailVerification'])->middleware('auth:sanctum');
