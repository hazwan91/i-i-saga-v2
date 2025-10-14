<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['guest'])->name('guest.')->group(function () {
    Route::get('login', [AuthController::class, 'create'])
        ->name('login.create');

    Route::post('login', [AuthController::class, 'store'])
        ->name('login.store');
});

Route::middleware(['auth', 'verified'])->name('auth.')->group(function () {
    Route::resource('', \App\Http\Controllers\Auth\Home\IndexController::class)
        ->only(['index'])
        ->names([
            'index' => 'home.index'
        ]);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('pengguna', \App\Http\Controllers\Auth\Admin\UserController::class)
            ->names([
                'index' => 'user.index',
                'create' => 'user.create',
                'store' => 'user.store',
                'show' => 'user.show',
                'edit' => 'user.edit',
                'update' => 'user.update',
                'destroy' => 'user.destroy',
            ])
            ->parameters([
                'pengguna' => 'user'
            ]);

        Route::resource('taraf-lantikan', \App\Http\Controllers\Auth\Admin\AppointStatusController::class)
            ->names([
                'index' => 'appointStatus.index',
                'create' => 'appointStatus.create',
                'store' => 'appointStatus.store',
                'show' => 'appointStatus.show',
                'edit' => 'appointStatus.edit',
                'update' => 'appointStatus.update',
                'destroy' => 'appointStatus.destroy',
            ])
            ->parameters([
                'taraf-lantikan' => 'appointStatus'
            ]);

        Route::resource('bangsa', \App\Http\Controllers\Auth\Admin\RaceController::class)
            ->names([
                'index' => 'race.index',
                'create' => 'race.create',
                'store' => 'race.store',
                'show' => 'race.show',
                'edit' => 'race.edit',
                'update' => 'race.update',
                'destroy' => 'race.destroy',
            ])
            ->parameters([
                'bangsa' => 'race'
            ]);

        Route::resource('jenis-agensi', \App\Http\Controllers\Auth\Admin\DepartmentTypeController::class)
            ->names([
                'index' => 'departmentType.index',
                'create' => 'departmentType.create',
                'store' => 'departmentType.store',
                'show' => 'departmentType.show',
                'edit' => 'departmentType.edit',
                'update' => 'departmentType.update',
                'destroy' => 'departmentType.destroy',
            ])
            ->parameters([
                'jenis-agensi' => 'departmentType'
            ]);

        Route::resource('agensi', \App\Http\Controllers\Auth\Admin\DepartmentController::class)
            ->names([
                'index' => 'department.index',
                'create' => 'department.create',
                'store' => 'department.store',
                'show' => 'department.show',
                'edit' => 'department.edit',
                'update' => 'department.update',
                'destroy' => 'department.destroy',
            ])
            ->parameters([
                'agensi' => 'department'
            ]);

        Route::resource('stesen', \App\Http\Controllers\Auth\Admin\StationController::class)
            ->names([
                'index' => 'station.index',
                'create' => 'station.create',
                'store' => 'station.store',
                'show' => 'station.show',
                'edit' => 'station.edit',
                'update' => 'station.update',
                'destroy' => 'station.destroy',
            ])
            ->parameters([
                'stesen' => 'station'
            ]);

        Route::get('zon/senarai', [\App\Http\Controllers\Auth\Admin\ZoneController::class, 'listZones'])
            ->name('zone.listZones');
        Route::resource('zon', \App\Http\Controllers\Auth\Admin\ZoneController::class)
            ->names([
                'index' => 'zone.index',
                'create' => 'zone.create',
                'store' => 'zone.store',
                'show' => 'zone.show',
                'edit' => 'zone.edit',
                'update' => 'zone.update',
                'destroy' => 'zone.destroy',
            ])
            ->parameters([
                'zon' => 'zone'
            ]);

        Route::resource('daerah', \App\Http\Controllers\Auth\Admin\DistrictController::class)
            ->names([
                'index' => 'district.index',
                'create' => 'district.create',
                'store' => 'district.store',
                'show' => 'district.show',
                'edit' => 'district.edit',
                'update' => 'district.update',
                'destroy' => 'district.destroy',
            ])
            ->parameters([
                'daerah' => 'district'
            ]);
    });

    Route::post('logout', [AuthController::class, 'destroy'])
        ->name('logout');
});
