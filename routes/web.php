<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatuseController;
use App\Http\Controllers\TaskController;

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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'statuses'], function(){
    Route::get('', [StatuseController::class, 'index'])->name('statuse.index');
    Route::get('create', [StatuseController::class, 'create'])->name('statuse.create');
    Route::post('store', [StatuseController::class, 'store'])->name('statuse.store');
    Route::get('edit/{statuse}', [StatuseController::class, 'edit'])->name('statuse.edit');
    Route::post('update/{statuse}', [StatuseController::class, 'update'])->name('statuse.update');
    Route::post('delete/{statuse}', [StatuseController::class, 'destroy'])->name('statuse.destroy');
    Route::get('show/{statuse}', [StatuseController::class, 'show'])->name('statuse.show');
    
});

Route::group(['prefix' => 'tasks'], function(){
    Route::get('', [TaskController::class, 'index'])->name('task.index');
    Route::get('create', [TaskController::class, 'create'])->name('task.create');
    Route::post('store', [TaskController::class, 'store'])->name('task.store');
    Route::get('edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
    Route::post('update/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::post('delete/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::get('show/{task}', [TaskController::class, 'show'])->name('task.show');
    Route::get('pdf/{task}', [TaskController::class, 'pdf'])->name('task.pdf');
});