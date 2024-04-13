<?php

use App\Livewire\Admin\PermissionIndex;
use App\Livewire\Admin\RoleHasPermissionsEdit;
use App\Livewire\Admin\RoleIndex;
use App\Livewire\Admin\UserHasRolesIndex;
use App\Livewire\DashboardIndex;
use App\Livewire\Evento\CalendarIndex;
use App\Livewire\Evento\EventoAreaIndex;
use App\Livewire\Evento\EventoGrupoIndex;
use App\Livewire\Evento\EventoIndex;
use App\Livewire\Evento\EventoLocalIndex;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    /* Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); */

    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    // Rotas p/ administrator permissões.
    Route::group(['middleware' => ['role:Admin']], function () { 
        Route::get('/admin/roles', RoleIndex::class)->name('admin.roles.index');
        Route::get('/admin/permissions', PermissionIndex::class)->name('admin.permissions.index');
        Route::get('/admin/user-has-roles', UserHasRolesIndex::class)->name('admin.user-has-roles.index');
        Route::get('/admin/role-has-permissions/{role}/edit', RoleHasPermissionsEdit::class)->name('admin.role-has-permissions');
    });

    Route::get('/evento/grupos', EventoGrupoIndex::class)->name('evento.grupos.index');
    Route::get('/evento/areas', EventoAreaIndex::class)->name('evento.areas.index');
    Route::get('/evento/locals', EventoLocalIndex::class)->name('evento.locals.index');
    Route::get('/eventos', EventoIndex::class)->name('eventos.index');
    Route::get('/evento/calendar', CalendarIndex::class)->name('evento.calendar');
});
