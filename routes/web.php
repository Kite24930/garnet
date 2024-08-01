<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');

    Route::get('/entry/{date?}', [EntryController::class, 'show'])->name('entry.show');
    Route::post('/entry', [EntryController::class, 'store'])->name('entry.store');
    Route::get('/entry/result/{date}', [EntryController::class, 'result'])->name('entry.result');

    Route::get('/logs/{year?}/{month?}/{user?}', [LogsController::class, 'show'])->name('logs.show');
    Route::get('/view/logs/{log}/{user}', [LogsController::class, 'view'])->name('logs.view');

    Route::get('/score/summary/{user?}', [ScoreController::class, 'score'])->name('score');
    Route::get('/score/new', [ScoreController::class, 'scoreNew'])->name('score.new');
    Route::post('/score', [ScoreController::class, 'scoreStore'])->name('score.store');
    Route::get('/score/edit/{score}', [ScoreController::class, 'scoreEdit'])->name('score.edit');
    Route::patch('/score/edit/{score}', [ScoreController::class, 'scoreUpdate'])->name('score.update');
    Route::delete('/score/{score}', [ScoreController::class, 'scoreDestroy'])->name('score.destroy');
    Route::get('/score/view/{score}', [ScoreController::class, 'scoreView'])->name('score.view');

    Route::get('/ranking/total', [ScoreController::class, 'totalRanking'])->name('ranking.total');
    Route::get('/ranking/month/{month?}', [ScoreController::class, 'monthlyRanking'])->name('ranking.monthly');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/icon', [ProfileController::class, 'icon'])->name('profile.icon');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mypage', [MainController::class, 'mypage'])->name('mypage');
    Route::get('/messages', [MainController::class, 'messages'])->name('messages');
    Route::get('/message/view/{message}', [MainController::class, 'messageView'])->name('message.view');
    Route::get('/message/list', [MainController::class, 'messageList'])->name('message.list');
    Route::get('/message/send', [MainController::class, 'messageSend'])->name('message.send');
    Route::post('/message/send', [MainController::class, 'messageStore'])->name('message.store');
    Route::get('/message/edit/{message}', [MainController::class, 'messageEdit'])->name('message.edit');
    Route::patch('/message/edit/{message}', [MainController::class, 'messageUpdate'])->name('message.update');
    Route::delete('/message/{message}', [MainController::class, 'messageDestroy'])->name('message.destroy');

    Route::post('/get/vapid_key', [MainController::class, 'getVapidKey'])->name('get.vapid_key');
    Route::post('/register/notification/token', [MainController::class, 'registerNotificationToken'])->name('register.notification.token');

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

        Route::get('/settings/users', [SettingController::class, 'users'])->name('setting.users');
        Route::post('/settings/user/assign/captain', [SettingController::class, 'assignCaptain'])->name('setting.user.assign.captain');
        Route::delete('/settings/user/unassign/captain/{user_id}', [SettingController::class, 'unassignCaptain'])->name('setting.user.unassign.captain');
    });

    Route::group(['middleware' => ['role:admin|captain']], function () {
        Route::get('/settings/mission', [SettingController::class, 'mission'])->name('setting.mission');
        Route::get('/settings/mission/new', [SettingController::class, 'missionNew'])->name('setting.mission.new');
        Route::post('/settings/mission/new', [SettingController::class, 'missionStore'])->name('setting.mission.store');
        Route::get('/settings/mission/edit/{mission}', [SettingController::class, 'missionEdit'])->name('setting.mission.edit');
        Route::patch('/settings/mission/edit/{mission}', [SettingController::class, 'missionUpdate'])->name('setting.mission.update');
        Route::delete('/settings/mission/{mission}', [SettingController::class, 'missionDestroy'])->name('setting.mission.destroy');
    });
});

require __DIR__.'/auth.php';
