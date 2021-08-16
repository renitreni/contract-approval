<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\MyContractController;
use App\Http\Controllers\SettingsPrivacyController;
use \App\Http\Controllers\ContractController;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home')->middleware(['can:home']);
        Route::post('/contract/search', [DashboardController::class, 'searchContract'])
             ->name('search.contract')
             ->middleware(['can:home']);
    });
    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('contracts.pending')->middleware(['can:contracts']);
        Route::get('/approved', [ContractController::class, 'indexApproved'])
             ->name('contracts.approved')
             ->middleware(['can:contracts']);
        Route::post('/pending/table', [ContractController::class, 'pendingTable'])->name('contracts.table.pending');
        Route::post('/approved/table', [ContractController::class, 'approvedTable'])->name('contracts.table.approved');
        Route::post('/approve/contract', [ContractController::class, 'approveContract'])->name('contracts.approval');
    });
    Route::prefix('mycontracts')->group(function () {
        Route::get('/', [MyContractController::class, 'index'])->name('my.contracts')->middleware(['can:my-contracts']);
        Route::post('/table', [MyContractController::class, 'table'])->name('my.contracts.table');
        Route::post('/store', [MyContractController::class, 'store'])->name('my.contracts.store');
        Route::post('/overview', [MyContractController::class, 'overview'])->name('my.contracts.overview');
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users')->middleware(['can:users']);
        Route::post('/table', [UsersController::class, 'usersTable'])->name('users.table');
        Route::post('/update', [UsersController::class, 'update'])->name('users.update');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
        Route::post('/cp', [UsersController::class, 'changePassword'])->name('users.cp');
        Route::post('/destroy', [UsersController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('roles')->middleware(['can:roles']);
        Route::post('/store', [RolesController::class, 'store'])->name('roles.store');
        Route::post('/update', [RolesController::class, 'update'])->name('roles.update');
        Route::post('/destroy', [RolesController::class, 'destroy'])->name('roles.delete');
        Route::post('/table', [RolesController::class, 'table'])->name('roles.table');
    });
    Route::prefix('settings-privacy')->group(function () {
        Route::get('/', [SettingsPrivacyController::class, 'index'])->name('settings-privacy');
        Route::post('/upload-photo', [SettingsPrivacyController::class, 'uploadPhoto'])->name('settings-privacy.up');
    });
});
