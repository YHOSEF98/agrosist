<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AcopioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\LaboreController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\CuadrillaController;
use App\Http\Controllers\PluviometroController;
use App\Http\Controllers\PluviometriaController;
use App\Http\Controllers\ReportesDiarioController;
use App\Http\Controllers\ProvedoreController;
use App\Http\Controllers\ConductoreController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AreaController;
use App\Http\Middleware\EnsureTeamMembership;
use App\Models\Roles;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/casa', [EmpresaController::class, 'index'])->name('casa');
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::resource('empresa', EmpresaController::class)->except(['show']);
        Route::resource('fincas', FincaController::class)->except(['show']);
        Route::resource('roles', RolesController::class)->except(['show']);
        Route::resource('lotes', LoteController::class)->except(['show']);
        Route::resource('acopios', AcopioController::class)->except(['show']);
        Route::resource('cargos', CargoController::class)->except(['show']);
        Route::resource('areas', AreaController::class)->except(['show']);
        Route::resource('labores', LaboreController::class)->except(['show']);
        Route::resource('trabajadores', TrabajadorController::class)->except(['show'])->parameters(['trabajadores' => 'trabajador',]);
        Route::resource('cuadrillas', CuadrillaController::class)->except(['show']);
        Route::resource('reportes-diarios', ReportesDiarioController::class)->except(['show','update']);
        // Route::resource('pluviometros', PluviometroController::class);
        // Route::resource('pluviometria', PluviometriaController::class)->except(['show']);
        // Route::resource('proveedores', ProvedoreController::class)->except(['show']);
        // Route::resource('conductores', ConductoreController::class)->except(['show']);
    });

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
