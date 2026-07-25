<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AcopioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/casa', [EmpresaController::class, 'index'])->name('casa');
Route::get('/login', [LoteController::class, 'index'])->name('login');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
    });

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('empresa');
    Route::get('/add', [EmpresaController::class, 'create'])->name('empresa-create');
    Route::get('/edit/{id}', [EmpresaController::class, 'edit'])->name('empresa-edit');
    Route::post('/add', [EmpresaController::class, 'store'])->name('empresa-store');
    Route::post('/edit/{id}', [EmpresaController::class, 'update'])->name('empresa-update');
    Route::post('/delete/{id}', [EmpresaController::class, 'destroy'])->name('empresa-destroy');
});

Route::prefix('finca')->group(function () {
    Route::get('/', [FincaController::class, 'index'])->name('fincas');
    Route::get('/add', [FincaController::class, 'create'])->name('finca-create');
    Route::get('/edit/{id}', [FincaController::class, 'edit'])->name('finca-edit');
    Route::post('/add', [FincaController::class, 'store'])->name('finca-store');
    Route::post('/edit/{id}', [FincaController::class, 'update'])->name('finca-update');
    Route::post('/delete/{id}', [FincaController::class, 'destroy'])->name('finca-destroy');
});

Route::prefix('lote')->group(function () {
    Route::get('/', [LoteController::class, 'index'])->name('lotes');
    Route::get('/add', [LoteController::class, 'create'])->name('lote-create');
    Route::get('/edit/{id}', [LoteController::class, 'edit'])->name('lote-edit');
    Route::post('/add', [LoteController::class, 'store'])->name('lote-store');
    Route::post('/edit/{id}', [LoteController::class, 'update'])->name('lote-update');
    Route::post('/delete/{id}', [LoteController::class, 'destroy'])->name('lote-destroy');
});

Route::prefix('acopio')->group(function () {
    Route::get('/', [AcopioController::class, 'index'])->name('acopios');
    Route::get('/add', [AcopioController::class, 'create'])->name('acopio-create');
    Route::get('/edit/{id}', [AcopioController::class, 'edit'])->name('acopio-edit');
    Route::post('/add', [AcopioController::class, 'store'])->name('acopio-store');
    Route::post('/edit/{id}', [AcopioController::class, 'update'])->name('acopio-update');
    Route::post('/delete/{id}', [AcopioController::class, 'destroy'])->name('acopio-destroy');
});

Route::resource('cargos', CargoController::class)->except(['show']);
Route::resource('trabajadores', TrabajadorController::class)->except(['show']);

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
