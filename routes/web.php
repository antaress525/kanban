<?php

use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileUserController;
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

Route::prefix('dashboard')
    ->middleware(['auth'])
    ->group(function () {
        
        /*
        |--------------------------------------------------------------------------
        | Kanban Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('kanban')
            ->name('kanban.')
            ->controller(KanbanController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{kanban}', 'show')
                    ->whereNumber('kanban')
                    ->name('show');
                Route::delete('/{kanban}', 'delete')
                    ->whereNumber('kanban')
                    ->name('delete');
                Route::get('seacrh', 'search')->name('search');
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Task Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('kanban')
            ->name('task.')
            ->controller(TaskController::class)
            ->group(function () {
                Route::post('/{kanban}', 'store')
                    ->whereNumber('kanban')
                    ->name('store');
                Route::put('/{task}', 'updateBase')
                    ->whereNumber('task')
                    ->name('update.base');
                Route::put('/tasks/{task}/reorder', 'reorder')
                    ->name('reorder');
                Route::delete('/tasks/{task}', 'destroy')
                    ->whereNumber('task')
                    ->name('destroy');
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Profile Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('profile')
            ->name('profile.')
            ->controller(ProfileUserController::class)
            ->group(function () {
                Route::put('/', 'update')->name('update');
            }
        );
    }
);


require __DIR__.'/auth.php';
