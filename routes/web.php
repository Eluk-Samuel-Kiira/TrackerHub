<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
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
    Route::post('/employee-status/{id}', [EmployeeController::class, 'changeEmployeeStatus'])->name('employee.status');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload_image');

    //projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::delete('/projects/{project}/users/{user}', [ProjectController::class, 'removeUser'])->name('projects.users.remove');
    Route::post('/projects/{project}', [ProjectController::class, 'addUsers'])->name('projects.users.add');
    Route::post('/projects/{project}', [ProjectController::class, 'addUsers'])->name('projects.users.add');

    //tasks
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.add');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.remove');


    //Roles permissions
    Route::resource('role', RoleController::class);
    Route::get('/permissions', [RoleController::class, 'permissionIndex'])->name('permission.index');
    Route::put('/update-permissions/{id}', [RoleController::class, 'updatePermission'])->name('permission.update');
    Route::put('/revoke-permissions/{id}', [RoleController::class, 'revokePermission'])->name('permission.revoke');
});


require __DIR__.'/auth.php';
