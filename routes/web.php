<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\DB;

Route::get('/test-sqlite', function () {

    DB::connection('sqlite_backup')->statement('SELECT 1');

    return 'SQLite funcionando';

});

/*
Route::get('/usuarios', [Controller2::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [Controller2::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [Controller2::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/{id}', [Controller2::class, 'destroy'])->name('usuarios.destroy');
*/

Route::get('/', [GeneralController::class, 'index']);
Route::post('/guardar_lead', [GeneralController::class, 'guardar_lead'])->name('guardar_lead');

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuario.store');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::get('/register', [UsuarioController::class, 'register']);

Route::post('/loginpost', [UsuarioController::class, 'loginpost']);
Route::post('/logout', [UsuarioController::class, 'logout']);

//admin
Route::middleware(['admin'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'home']);
    Route::get('/ver_usuarios', [UsuarioController::class, 'ver_usuarios']);
    Route::get('/ver_almacenes', [UsuarioController::class, 'ver_alamcenes']);
    Route::get('/ver_envios', [UsuarioController::class, 'ver_envios']);
    Route::get('/ver_documentos', [UsuarioController::class, 'ver_documentos']);
    Route::get('/ver_pagos', [UsuarioController::class, 'ver_pagos']);

//admin - clientes
Route::get('/ver_clientes', [ClienteController::class, 'ver_clientes']);
Route::post('/guardar_cliente', [ClienteController::class, 'guardar_cliente']);
Route::post('/editar_cliente/{id}', [ClienteController::class, 'editar_cliente']);
Route::get('/eliminar_cliente/{id}', [ClienteController::class, 'eliminar_cliente']);

//admin - leads
Route::get('/ver_leads', [AdminController::class, 'ver_leads']);
});

Route::get('/chat', [UsuarioController::class, 'ver_chat']);

//cliente
Route::get('/home_cliente', [ClienteController::class, 'home']);
Route::get('/ver_ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/agregar_venta', [VentaController::class, 'agregar_venta']);
Route::post('/ventas/store', [VentaController::class, 'store'])->name('ventas.store');
Route::get('/ventas/{id}',   [VentaController::class, 'show'])->name('ventas.show');
Route::get('/buscar-cliente',[VentaController::class, 'buscarCliente'])->name('buscar.cliente');