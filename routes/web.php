<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RolePermissionController ;

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

    // Route::group(['middleware' => ['permission:school_view']], function () {
    //     Route::get('/schools', 'SchoolController@index');
    // });

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // School Management
    Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
    Route::post('/schools', [SchoolController::class, 'store'])->name('schools.add');
    Route::get('/schools/create', function () {
        return view('schools.create');
    })->name('schools.create');

    //Course Management
    Route::get('/course/create', function () {
        return view('course.create');
    })->name('course.create');
    Route::get('/courses', [CourseController::class, 'index'])->name('course.list');
    Route::post('/courses', [CourseController::class, 'store'])->name('course.add');

    //Batch Management
    Route::get('/batches', [BatchController::class, 'index'])->name('batch.list');
    Route::get('/batch/create', [BatchController::class, 'create'])->name('batch.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('batch.add');

    //Department Management
    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.list');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('department.add');

    //Role and Permission Management

    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');

});


