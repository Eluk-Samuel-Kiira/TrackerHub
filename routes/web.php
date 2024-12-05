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
use App\Http\Controllers\ProjectFileController;

use App\Http\Controllers\Users\EmployeeController;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\GeneralReportsController;
use App\Http\Controllers\Project\RequistionController;
use App\Http\Controllers\Project\ProjectExpenseController;
use App\Http\Controllers\ProjectInvoiceController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home.welcome');
});


Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/get-project-progress-data', [DashboardController::class, 'getProjectProgressData']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Currencies
    Route::resource('currencies', CurrencyController::class);
    Route::post('/currency-status/{id}', [CurrencyController::class, 'changeCurrencyStatus'])->name('currency.status');


    // Project Categories
    Route::resource('project_categories', ProjectCategoryController::class);
    Route::post('/category-status/{id}', [ProjectCategoryController::class, 'changeCategoryStatus'])->name('category.status');

    Route::post('/project_categories', [ProjectCategoryController::class, 'store'])->name('project_categories.store');

    // Departments
    Route::resource('departments', DepartmentController::class);
    Route::post('/department-status/{id}', [DepartmentController::class, 'changeDepartmentStatus'])->name('employee.status');

    // Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::post('/client-status/{id}', [ClientController::class, 'changeClientStatus'])->name('employee.status');

    // Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Users
    Route::post('/users', [UserController::class, 'store']);


    // Requistions
    Route::resource('requistion', RequistionController::class);
    Route::post('/requisition-status/{id}', [RequistionController::class, 'changeRequisitionStatus'])->name('requistion.status');
    Route::post('/requisition-response/{id}', [RequistionController::class, 'changeRequisitionResponse'])->name('requistion.response');
    Route::post('/requisition.upload/{id}', [RequistionController::class, 'uploadRequisitionFile'])->name('requisition.upload');
    Route::post('/requisition/delete-file', [RequistionController::class, 'deleteFile'])->name('requisition.deleteFile');
    Route::get('/project-expenses', [ProjectExpenseController::class, 'index'])->name('expense.index');


    // HR
    Route::resource('employee', EmployeeController::class);
    Route::post('/employee-status/{id}', [EmployeeController::class, 'changeEmployeeStatus'])->name('employee.status');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload_image');

    //projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::delete('/projects/{project}/users/{user}', [ProjectController::class, 'removeUser'])->name('projects.users.remove');
    Route::post('/projects/{project}', [ProjectController::class, 'addUsers'])->name('projects.users.add');
    Route::post('/projects/{project}', [ProjectController::class, 'addUsers'])->name('projects.users.add');

    //tasks
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.add');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.remove');

    //files
    Route::post('/files', [ProjectFileController::class, 'store'])->name('files.add');
    Route::delete('/files/{file}', [ProjectFileController::class, 'destroy'])->name('files.remove');

    //invoices
    Route::resource('invoice', ProjectInvoiceController::class);

    Route::post('/invoices', [ProjectInvoiceController::class, 'store'])->name('invoices.add');
    Route::delete('/invoices/{file}', [ProjectInvoiceController::class, 'destroy'])->name('invoices.remove');




    // Document Types
    Route::get('/document-type', [SettingController::class, 'documentIndex'])->name('document.index');
    Route::post('/document-type', [SettingController::class, 'documentStore'])->name('document.store');
    Route::put('/document/{id}', [SettingController::class, 'documentUpdate'])->name('document.update');
    Route::post('/document-status/{id}', [SettingController::class, 'changeDocumentStatus'])->name('document.status');




    //Roles permissions
    Route::resource('role', RoleController::class);
    Route::get('/permissions', [RoleController::class, 'permissionIndex'])->name('permission.index');
    Route::put('/update-permissions/{id}', [RoleController::class, 'updatePermission'])->name('permission.update');
    Route::put('/revoke-permissions/{id}', [RoleController::class, 'revokePermission'])->name('permission.revoke');

    //Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/settings-update', [SettingController::class, 'updateSettings'])->name('setting.update');
    Route::post('/logo-upload', [SettingController::class, 'uploadLogo'])->name('logo.upload');
    Route::post('/favicon-upload', [SettingController::class, 'uploadFavicon'])->name('favicon.upload');
    Route::get('/database/backup/{element}', [SettingController::class, 'backupOrRestore'])->name('database.backup');
    Route::post('/database/restore', [SettingController::class, 'restore'])->name('database.restore');

    // General Reports
    Route::get('/general-reports', [GeneralReportsController::class, 'index'])->name('report.index');

});


require __DIR__.'/auth.php';
