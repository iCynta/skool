<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




// Custom Routes



Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // Resource route for Schools
    Route::get('/schools', [App\Http\Controllers\SchoolController::class, 'index'])->name('schools.index');
    Route::post('/schools', [App\Http\Controllers\SchoolController::class, 'store'])->name('schools.add');
    Route::get('/schools/data', [App\Http\Controllers\SchoolController::class, 'getSchools'])->name('schools.getSchools');
    Route::get('/schools/create', function () {
        return view('schools.create');
    })->name('schools.create');
});

