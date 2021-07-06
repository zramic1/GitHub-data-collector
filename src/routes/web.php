<?php

use App\Http\Controllers\Auth\AuthController;
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

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Followers
Route::prefix('followers')->middleware('auth')->group(function () {
    Route::get('/', [FollowerController::class, 'index'])->name('web.followers.index');
    Route::post('/', [FollowerController::class, 'store'])->name('web.followers.store');
    Route::get('/download', [FollowerController::class, 'download'])->name('web.followers.download');
});

//Github Auth
Route::prefix('github')->group(function () {
    Route::get('/login/redirect', [GithubLoginController::class, 'loginRedirect'])->name('github.login.redirect');
    Route::get('/redirect', [GithubLoginController::class, 'redirect'])->name('github.redirect');
    Route::get('/callback', [GithubLoginController::class, 'login'])->name('github.callback');
});

//Repositories
Route::prefix('repositories')->group(function () {
    Route::get('/', [RepositoryController::class, 'index'])->name('web.repositories.index');
    Route::post('/', [RepositoryController::class, 'store'])->name('web.repositories.store');
    Route::get('/download/{nickname}', [RepositoryController::class, 'download'])->name('web.repositories.download');
});
