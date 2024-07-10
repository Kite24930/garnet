<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');

    Route::get('/entry', [EntryController::class, 'show'])->name('entry.show');
    Route::post('/entry', [EntryController::class, 'store'])->name('entry.store');

    Route::get('/logs', [LogsController::class, 'show'])->name('logs.show');
    Route::get('/logs/{log}', [LogsController::class, 'view'])->name('logs.view');
    Route::get('/logs/edit/{log}', [LogsController::class, 'edit'])->name('logs.edit');
    Route::patch('/logs/edit/{log}', [LogsController::class, 'update'])->name('logs.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/settings', [SettingController::class, 'show'])->name('setting.show');
        Route::get('/settings/rank', [SettingController::class, 'rank'])->name('setting.rank');
        Route::post('/settings/rank', [SettingController::class, 'rankStore'])->name('setting.rank.store');
        Route::get('/settings/category', [SettingController::class, 'category'])->name('setting.category');
        Route::post('/settings/category', [SettingController::class, 'categoryStore'])->name('setting.category.store');
        Route::get('/settings/group', [SettingController::class, 'group'])->name('setting.group');
        Route::post('/settings/group', [SettingController::class, 'groupStore'])->name('setting.group.store');
        Route::get('/settings/item', [SettingController::class, 'item'])->name('setting.item');
        Route::post('/settings/item', [SettingController::class, 'itemStore'])->name('setting.item.store');
        Route::get('/settings/task', [SettingController::class, 'task'])->name('setting.task');
        Route::get('/settings/task/new', [SettingController::class, 'taskNew'])->name('setting.task.new');
        Route::post('/settings/task', [SettingController::class, 'taskStore'])->name('setting.task.store');
        Route::get('/settings/task/{task}', [SettingController::class, 'taskEdit'])->name('setting.task.edit');
        Route::patch('/settings/task/{task}', [SettingController::class, 'taskUpdate'])->name('setting.task.update');
        Route::delete('/settings/task/{task}', [SettingController::class, 'taskDestroy'])->name('setting.task.destroy');
    });
});

require __DIR__.'/auth.php';
