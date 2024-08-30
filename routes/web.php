<?php

use App\Http\Controllers\PaymentController;
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
use App\Http\Controllers\EmployeeExpenseMasterController;
use App\Http\Controllers\EmployeeExpenseController;
use App\Http\Controllers\StudentsExpenseMaster;
use App\Http\Controllers\StudentsExpenseController;
use App\Http\Controllers\StudentReportController;
use App\Models\School;
use App\Models\User;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

// Public Routes
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {

    $school = School::first();
    session(['school' => $school]); // Store school detail in session

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
    Route::middleware(['role:Management|Organizer'])->group(function () {
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::post('/schools', [SchoolController::class, 'store'])->name('schools.add');
        Route::get('/schools/create', function () {
            return view('schools.create');
        })->name('schools.create');
    });

    // Course Management
    Route::middleware(['role:Management|Teacher'])->group(function () {
        Route::get('/course/create', function () {
            return view('course.create');
        })->name('course.create');
        Route::get('/course', [CourseController::class, 'index'])->name('course.list');
        Route::post('/course', [CourseController::class, 'store'])->name('course.add');
    });

    // Batch Management
    Route::middleware(['role:Management|Teacher'])->group(function () {
        Route::get('/batches', [BatchController::class, 'index'])->name('batch.list');
        Route::get('/batch/create', [BatchController::class, 'create'])->name('batch.create');
        Route::post('/batches', [BatchController::class, 'store'])->name('batch.add');
    });

    // Department Management
    Route::middleware(['role:Management|Organizer'])->group(function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('department.list');
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('department.add');
    });

    // Role and Permission Management
    Route::middleware(['role:Management'])->group(function () {
        Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
        Route::put('/roles-permissions/update', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
    });

    // Student Management
    Route::middleware(['role:Management|Organizer'])->group(function () {
        Route::resource('students', StudentController::class)->except(['show']); // Exclude 'show' route if not needed
        Route::post('/students/seats/check', [StudentController::class, 'checkBatchSeatStatus'])->name('students.seats.check');
        Route::post('/students/admission/check', [StudentController::class, 'searchAdmissions'])->name('students.admission.check');
        Route::get('/student/expenses', [StudentsExpenseController::class, 'index'])->name('student.expenses');
        Route::post('/student/expenses/details', [StudentsExpenseController::class, 'searchStudentsDetails'])->name('student.expenses.details');
        Route::post('/student/expenses/reciepts', [StudentsExpenseController::class, 'loadExpenseReciepts'])->name('student.expenses.reciepts');
        Route::post('/student/expenses/reciepts/save', [StudentsExpenseController::class, 'create'])->name('student.expenses.reciepts.save');
        Route::post('/student/expenses/feesexceed/check', [StudentsExpenseController::class, 'checkStudentFeesExceeded'])->name('student.expenses.feesexceed.check');
        Route::post('/student/expenses/receipts/update/{id}', [StudentsExpenseController::class, 'update'])->name('student.expenses.reciepts.update');
        Route::get('/students/loadTable', [StudentController::class, 'loadTable'])->name('students.loadTable');
        Route::get('/reciepts/{id}', [RecieptController::class, 'view'])->name('reciepts');
    });

    // Vehicle Management
    Route::middleware(['role:Management|Organizer'])->group(function () {
        Route::resource('vehicles', VehicleController::class);
    });

    // Vehicle Expenses
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::get('/vehicles/expense/new', [VehicleController::class, 'CreateExpense'])->name('vehicle.expense.new');
        Route::post('/vehicles/expense/add', [VehicleController::class, 'AddVehicleExpense'])->name('vehicle.expense.store');
        Route::get('/vehicles/expense/index', [VehicleController::class, 'VehicleExpenses'])->name('vehicle.expense.index');
        Route::get('/vehicles/expense/view/{expense_id}', [VehicleController::class, 'viewExpense'])->name('vehicle.expense.view');
        Route::get('/vehicles/expense/voucher/{expense_id}', [VehicleController::class, 'viewExpenseVoucher'])->name('vehicle.expense.voucher');
    });

    // Employee Expense Masters
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::resource('employee_expense_masters', EmployeeExpenseMasterController::class);
    });

    // Employee Expenses
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::resource('employee/expenses', EmployeeExpenseController::class);
        Route::get('expense/voucher/print/{voucher}', [EmployeeExpenseController::class, 'printExpenseVoucher'])->name('print.expense.voucher');
    });

    // Employee Payments
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::get('payment/create/', [PaymentController::class, 'create'])->name('payment.create');
        Route::get('payment/store/', [PaymentController::class, 'store'])->name('payments.store');
        
    });

    // Settings
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::get('/settings/expense/master', function () {
            return view('settings.students_expenses');
        })->name('settings.expense.master');
        Route::get('/settings/expense/master/list', [StudentsExpenseMaster::class, 'loadStudentsExpense'])->name('settings.expense.master.list');
        Route::post('/settings/expense/master/entry/{id?}', [StudentsExpenseMaster::class, 'save'])->name('settings.expense.master.entry');
    });
//reports
    Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
        Route::get('/reports/students/index', [StudentReportController::class, 'index'])->name('reports.students.index');
    });
});
Route::get('/export-students', [StudentReportController::class, 'export'])->name('export.students');

Route::middleware(['role:Management|Organizer|Accountant'])->group(function () {
    Route::get('/payments/history/', [PaymentController::class, 'index'])->name('payments.history');
    Route::get('/cashInHand/settle/', [PaymentController::class, 'create'])->name('payments.cashInHand.settle');
    Route::post('/cashInHand/settle/', [PaymentController::class, 'store'])->name('payments.cashInHand.settle');
});



