<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('task.list');
});

Auth::routes();

// Rute yang dapat diakses tanpa login
Route::get('/', [TasksController::class, 'index'])->name('home');

// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/task/create', [TasksController::class, 'create']);
    Route::post('/task/store', [TasksController::class, 'store']);

    Route::get('/task/edit/{id}', [TasksController::class, 'edit'])->name('task.edit');
    Route::post('/task/update/{id}', [TasksController::class, 'update'])->name('task.update');
    Route::delete('/task/destroy/{id}', [TasksController::class, 'destroy'])->name('task.destroy');

    Route::post('/task/update-sort-order', [TasksController::class, 'updateSortOrder'])->name('task.updateSortOrder');
});
