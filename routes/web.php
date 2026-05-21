<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Aquí irá el controlador de autenticación nativo más adelante
    return back()->withErrors(['message' => 'Autenticación no implementada aún en el backend.']);
});

// Rutas de Registro de Empresa (Tenant onboarding)
Route::get('/registro-empresa', function () {
    return view('auth.register_company');
})->name('registro.empresa');

Route::post('/registro-empresa', function () {
    // Aquí irá el controlador para crear la clínica y el usuario administrador en el backend
    return back()->withErrors(['message' => 'El registro del backend se implementará en la siguiente fase.']);
})->name('registro.empresa.guardar');
