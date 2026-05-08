<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;

/*
Route::get('/usuarios', [Controller2::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [Controller2::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [Controller2::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/{id}', [Controller2::class, 'destroy'])->name('usuarios.destroy');
*/
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuario.store');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/login', [UsuarioController::class, 'login']);
Route::get('/register', [UsuarioController::class, 'register']);

Route::post('/loginpost', [UsuarioController::class, 'loginpost']);
Route::post('/logout', [UsuarioController::class, 'logout']);
//admin
Route::get('/home_admin', [AdminController::class, 'home']);
Route::get('/ver_usuarios', [UsuarioController::class, 'ver_usuarios']);

//cliente
Route::get('/home_cliente', [ClienteController::class, 'home']);