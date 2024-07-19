<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RecieptController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StudentsExpenseMaster;
use App\Http\Controllers\StudentsExpenseController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Custom Routes

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('users', [UserController::class, 'update'])->name('user.add');

    // School Management
    Route::group(['middleware' => ['role:Management|Organizer']], function () {
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::post('/schools', [SchoolController::class, 'store'])->name('schools.add');
        Route::get('/schools/create', function () {
            return view('settings.students_expenses');
        })->name('schools.create');
    });

    // Course Management
    Route::group(['middleware' => ['role:Management|Teacher']], function () {
        Route::get('/course/create', function () {
            return view('course.create');
        })->name('course.create');
        Route::get('/courses', [CourseController::class, 'index'])->name('course.list');
        Route::post('/courses', [CourseController::class, 'store'])->name('course.add');
    });

    // Batch Management
    Route::group(['middleware' => ['role:Management|Teacher']], function () {
        Route::get('/batches', [BatchController::class, 'index'])->name('batch.list');
        Route::get('/batch/create', [BatchController::class, 'create'])->name('batch.create');
        Route::post('/batches', [BatchController::class, 'store'])->name('batch.add');
    });

    // Department Management
    Route::group(['middleware' => ['role:Management|Organizer']], function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('department.list');
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('department.add');
    });

    // Role and Permission Management
    Route::group(['middleware' => ['role:Management']], function () {
        Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
        Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
    });
    Route::group(['middleware' => ['role:Management|Organizer']], function () {
        Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    });

    //Student Management
    Route::group(['middleware' => ['role:Management|Organizer']], function () {
        Route::resource('students', StudentController::class); // Will create all the routes
        Route::post('/students/seats/check', [StudentController::class, 'checkBatchSeatStatus'])->name('students.seats.check');
        Route::post('/students/admission/check', [StudentController::class, 'searchAdmissions'])->name('students.admission.check');
        Route::get('/student/expenses', [StudentsExpenseController::class, 'index'])->name('student.expenses');
        Route::post('/student/expenses/details', [StudentsExpenseController::class, 'searchStudentsDetails'])->name('student.expenses.details');
        Route::post('/student/expenses/reciepts', [StudentsExpenseController::class, 'loadExpenseReciepts'])->name('student.expenses.reciepts');
        Route::post('/student/expenses/reciepts/save', [StudentsExpenseController::class, 'store'])->name('student.expenses.reciepts.save');
        // routes/web.php
Route::post('/student/expenses/receipts/update/{id}', [StudentsExpenseController::class, 'update'])->name('student.expenses.reciepts.update');

        // Route::post('/students/expenses', [StudentController::class, 'expensesDetails'])->name('students.expenses');
        Route::resource('students', StudentController::class)->except(['show']);
Route::get('/students/loadTable', [StudentController::class, 'loadTable'])->name('students.loadTable');
Route::get('/reciepts/{id}', [RecieptController::class, 'view'])->name('reciepts');

    });

    //Vehicle Management
    Route::group(['middleware' => ['role:Management|Organizer']], function () {
        Route::resource('vehicles', VehicleController::class); // Will create all the routes
        
        Route::get('/vehicles/expense/', [VehicleController::class, 'CreateExpense'])->name('vehicle.expense.add');
    });

    //Vehicle Expenses
    Route::group(['middleware' => ['role:Management|Organizer|Accountant']], function () {
        Route::resource('vehicles', VehicleController::class); // Will create all the routes
        
        Route::get('/vehicles/expense/new', [VehicleController::class, 'CreateExpense'])->name('vehicle.expense.new');
        // Route::post('/vehicles/expense/add', [VehicleController::class, 'AddVehicleExpense'])->name('vehicle.expense.add');
        Route::get('/vehicles/expense/index', [VehicleController::class, 'VehicleExpenses'])->name('vehicle.expense.index');
    });

       // Settings
       Route::group(['middleware' => ['role:Management|Organizer|Accountant']], function () {
        Route::get('/settings/expense/master', function () {
            return view('settings.students_expenses');
        })->name('settings.expense.master');
        Route::get('/settings/expense/master/list', [StudentsExpenseMaster::class, 'loadStudentsExpense'])
        ->name('settings.expense.master.list');
        Route::post('/settings/expense/master/entry/{id?}', [StudentsExpenseMaster::class, 'save'])->name('settings.expense.master.entry');

        });

});
