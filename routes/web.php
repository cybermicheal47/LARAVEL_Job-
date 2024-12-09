<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;
use App\Http\Controllers\JobController;
    use App\Http\Controllers\HomeController;

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


Route::get('/' , [HomeController::class, 'index']  );
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

Route::resource('jobs', JobController::class);


Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});




