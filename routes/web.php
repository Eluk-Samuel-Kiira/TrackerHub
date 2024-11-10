<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Users\EmployeeController;
use App\Http\Controllers\Users\RoleController;


Route::get('/', function () {
    return view('home.welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Currencies
    Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies.store');

    // Project Categories
    Route::post('/project_categories', [ProjectCategoryController::class, 'store'])->name('project_categories.store');

    // Departments
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

    // Clients
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Users
    Route::post('/users', [UserController::class, 'store']);
    

    // HR
    Route::resource('employee', EmployeeController::class);

    //Roles permissions
    Route::resource('role', RoleController::class);
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');



require __DIR__.'/auth.php';
