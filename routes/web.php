<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;
use App\Http\Controllers\JobController;
    use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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


Route::get('/' , [HomeController::class, 'index'])->name('home');
Route::get('/jobs', function () {
    return  "available jobs";
});
Route::get('posts/{id}', function($id) {
    return 'Post '.$id;
});



Route::get('/user',function (Request $request) {
    return $request->query('name');
});


Route::get('/users',function (Request $request) {
    return $request->all();
});

Route::resource('jobs', JobController::class)->middleware('auth')
    ->only(['edit', 'create', 'destroy','update',]);

Route::resource('jobs', JobController::class)->except(['create', 'edit', 'destroy']);


Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function(){
    Route::get('/register',[RegisterController::class, 'register'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.store');
    Route::get('/login',[LoginController::class, 'login'])->name('login');
    Route::post('/login',[LoginController::class, 'authenticate'])->name('login.authenticate');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});




