<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\RegisterConfirmationController;
use App\Http\Controllers\BestRepliesController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadSubscriptionsController;
use App\Http\Controllers\UserNotificationsController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('threads', 'ThreadController')->except(['show', 'destroy']);
Route::get('/threads/{channel}', [ThreadController::class, 'index'])->name('threads.index.channel');
Route::get('/threads/{channel}/{thread}/replies', [ReplyController::class, 'index']);
Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store']);
Route::get('/threads/{channel}/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::delete('/threads/{channel}/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store'])->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy'])->middleware('auth');

Route::post('/replies/{reply}/favorites', [FavoriteController::class, 'store'])->name('replies.favorites');
Route::delete('/replies/{reply}/favorites', [FavoriteController::class, 'destroy'])->name('replies.favorites.destroy');
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');
Route::patch('/replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');

Route::post('/replies/{reply}/best', [BestRepliesController::class, 'store'])->name('best-replies.store');

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profiles');
Route::get('/profiles/{user}/notifications', [UserNotificationsController::class, 'index'])->name('profiles.notification.index');
Route::delete('/profiles/{user}/notifications/{notification}', [UserNotificationsController::class, 'destroy'])->name('profiles.notification.destroy');

Route::get('/register/confirm', [RegisterConfirmationController::class, 'index'])->name('register.confirm');

Route::get('api/users', [UserController::class, 'index']);
Route::post('api/users/{user}/avatar', [UserController::class, 'storeAva'])->name('user.store.ava');
