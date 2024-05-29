<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SchoolController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\BatchController;
// use App\Http\Controllers\DepartmentController;
// use App\Http\Controllers\RolePermissionController ;
// use App\Http\Controllers\Auth\RegisterController;



// Route::get('/', function () {
//     return view('welcome');
// });


// Auth::routes(['register' => false]);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




// // Custom Routes



// Route::group(['middleware' => 'auth'], function () {

//     // Route::group(['middleware' => ['permission:school_view']], function () {
//     //     Route::get('/schools', 'SchoolController@index');
//     // });

//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });

//     // Registration Routes...
//     Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('register', [RegisterController::class, 'register']);

//     // School Management
//     Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
//     Route::post('/schools', [SchoolController::class, 'store'])->name('schools.add');
//     Route::get('/schools/create', function () {
//         return view('schools.create');
//     })->name('schools.create');

//     //Course Management
//     Route::get('/course/create', function () {
//         return view('course.create');
//     })->name('course.create');
//     Route::get('/courses', [CourseController::class, 'index'])->name('course.list');
//     Route::post('/courses', [CourseController::class, 'store'])->name('course.add');

//     //Batch Management
//     Route::get('/batches', [BatchController::class, 'index'])->name('batch.list');
//     Route::get('/batch/create', [BatchController::class, 'create'])->name('batch.create');
//     Route::post('/batches', [BatchController::class, 'store'])->name('batch.add');

//     //Department Management
//     Route::get('/departments', [DepartmentController::class, 'index'])->name('department.list');
//     Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
//     Route::post('/departments', [DepartmentController::class, 'store'])->name('department.add');

//     //Role and Permission Management
//     Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
//     Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');

//     // Employee Master
//     Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');

// });



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Custom Routes
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Registration Users Routes
    Route::group(['middleware' => ['permission:employee_add']], function () {
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });

    // School Management
    Route::group(['middleware' => ['permission:school_view']], function () {
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
    });
    Route::group(['middleware' => ['permission:school_add']], function () {
        Route::post('/schools', [SchoolController::class, 'store'])->name('schools.add');
    });
    Route::group(['middleware' => ['permission:school_add']], function () {
        Route::get('/schools/create', function () {
            return view('schools.create');
        })->name('schools.create');
    });

    // Course Management
    Route::group(['middleware' => ['permission:course_add']], function () {
        Route::get('/course/create', function () {
            return view('course.create');
        })->name('course.create');
    });
    Route::group(['middleware' => ['permission:course_view']], function () {
        Route::get('/courses', [CourseController::class, 'index'])->name('course.list');
    });
    Route::group(['middleware' => ['permission:course_add']], function () {
        Route::post('/courses', [CourseController::class, 'store'])->name('course.add');
    });

    // Batch Management
    Route::group(['middleware' => ['permission:batch_view']], function () {
        Route::get('/batches', [BatchController::class, 'index'])->name('batch.list');
    });
    Route::group(['middleware' => ['permission:batch_add']], function () {
        Route::get('/batch/create', [BatchController::class, 'create'])->name('batch.create');
    });
    Route::group(['middleware' => ['permission:batch_add']], function () {
        Route::post('/batches', [BatchController::class, 'store'])->name('batch.add');
    });

    // Department Management
    Route::group(['middleware' => ['permission:department_view']], function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('department.list');
    });
    Route::group(['middleware' => ['permission:department_add']], function () {
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    });
    Route::group(['middleware' => ['permission:department_add']], function () {
        Route::post('/departments', [DepartmentController::class, 'store'])->name('department.add');
    });

    Route::group(['middleware' => ['can:permissions_add']], function () {
        // Role and Permission Management
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
    });

    
    Route::group(['middleware' => ['permission:permissions_view']], function () {
        Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    });
    Route::group(['middleware' => ['permission:permissions_add']], function () {
        Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
    });
    Route::get('/check-permissions', function () {
        $user = Auth::user();
        
        $permissions = $user->getAllPermissions();
        dd($user, $permissions);
    })->middleware('auth');
});



