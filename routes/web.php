<?php

use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->middleware(['auth'])->name('kanban.')->controller(KanbanController::class)->group(function () {
    Route::get('/kanban', 'index')->name('index');
    Route::post('/kanban', 'store')->name('store');
    Route::get('kanban/{kanban}/', 'show')
        ->whereNumber('kanban')
        ->name('show');
    Route::delete('kanban/{kanban}/', 'delete')
        ->whereNumber('kanban')
        ->name('delete');
});

Route::prefix('dashboard')->middleware(['auth'])->name('task.')->controller(TaskController::class)->group(function() {
    Route::post('kanban/{kanban}', 'store')
        ->whereNumber('kanban')
        ->name('store');
    Route::put('kanban/{task}', 'updateBase')
        ->whereNumber('task')
        ->name('update.base');
});


require __DIR__.'/auth.php';
