<?php

use App\Http\Controllers\Auth\GithubLoginController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\RepositoryController;
use App\Http\Controllers\Web\FollowerController;
use Illuminate\Support\Facades\Route;

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

//Home
Route::get('/', [HomeController::class, 'index'])->name('web.home');

// Auth
Route::get('/github/login/redirect', [GithubLoginController::class, 'loginRedirect'])->name('github.login.redirect');
Route::get('/github/redirect', [GithubLoginController::class, 'redirect'])->name('github.redirect');
Route::get('/github/callback', [GithubLoginController::class, 'login'])->name('github.callback');
Route::get('/login', [GithubLoginController::class, 'index'])->name('login');
Route::post('/logout', [GithubLoginController::class, 'logout'])->name('logout');

//Repositories
Route::prefix('repositories')->group(function () {
    Route::get('/', [RepositoryController::class, 'index'])->name('web.repositories.index');
    Route::post('/', [RepositoryController::class, 'store'])->name('web.repositories.store');
    Route::get('/download', [RepositoryController::class, 'download'])->name('web.repositories.download');
});

//Followers
Route::prefix('followers')->middleware('auth')->group(function () {
    Route::get('/', [FollowerController::class, 'index'])->name('web.followers.index');
    Route::post('/', [FollowerController::class, 'store'])->name('web.followers.store');
    Route::get('/download', [FollowerController::class, 'download'])->name('web.followers.download');
});
