<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [TasksController::class, 'index'])->name('task.index');

Route::prefix('task')->controller(TasksController::class)->name('task.')->middleware('auth')->group(function () {
  Route::get('/', 'get')->name('get');
  Route::post('/', 'store')->name('store');
  Route::put('{task}', 'update')->name('update');
  Route::delete('{task}', 'destroy')->name('destroy');
  Route::put('/order/{task}', 'updateOrder')->name('order');
});

require __DIR__.'/auth.php';
