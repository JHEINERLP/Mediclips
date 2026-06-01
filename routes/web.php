<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterCompanyController;
use App\Http\Controllers\Auth\RegisterPacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntregaMedicamentoController;
use App\Http\Controllers\FarmaceuticoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ReporteClinicoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/registro-empresa', [RegisterCompanyController::class, 'create'])->name('registro.empresa');
    Route::post('/registro-empresa', [RegisterCompanyController::class, 'store'])->name('registro.empresa.guardar');
    Route::get('/registro-paciente', [RegisterPacienteController::class, 'create'])->name('registro.paciente');
    Route::post('/registro-paciente', [RegisterPacienteController::class, 'store'])->name('registro.paciente.guardar');
});

Route::middleware(['auth', 'clinica'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('role:admin,medico,paciente')->group(function () {
        Route::resource('citas', CitaController::class);
        Route::patch('citas/{cita}/estado', [CitaController::class, 'updateEstado'])->name('citas.estado');
    });

    Route::middleware('role:admin,medico')->group(function () {
        Route::resource('reportes', ReporteClinicoController::class);
        Route::resource('recetas', RecetaController::class);
    });

    Route::middleware('role:admin,farmaceutico')->group(function () {
        Route::resource('medicamentos', MedicamentoController::class)->except(['show']);
        Route::resource('entregas', EntregaMedicamentoController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('medicos', MedicoController::class);
        Route::post('medicos/{medico}/reenviar-invitacion', [MedicoController::class, 'reenviarInvitacion'])->name('medicos.reenviar');
        Route::resource('pacientes', PacienteController::class);
        Route::post('pacientes/{paciente}/reenviar-invitacion', [PacienteController::class, 'reenviarInvitacion'])->name('pacientes.reenviar');
        Route::resource('farmaceuticos', FarmaceuticoController::class)->except(['show']);
        Route::post('farmaceuticos/{farmaceutico}/reenviar-invitacion', [FarmaceuticoController::class, 'reenviarInvitacion'])->name('farmaceuticos.reenviar');
        Route::resource('horarios', HorarioController::class)->except(['show']);
        Route::resource('especialidades', EspecialidadController::class)->except(['show']);
        Route::get('clinica/edit', [ClinicaController::class, 'edit'])->name('clinica.edit');
        Route::put('clinica', [ClinicaController::class, 'update'])->name('clinica.update');
    });
});
