<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PrecioController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\RollbackController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SolicitudController;

Route::get('/test-sqlite', function () {

    DB::connection('sqlite_backup')->statement('SELECT 1');

    return 'SQLite funcionando';

});
//cliente
Route::get('/envios_cliente', [ClienteController::class, 'envios_cliente']);
Route::get('/detalle_orden/{id}', [ClienteController::class, 'detalle_orden'])->name('detalle_orden.show');
Route::get('/configuracion', [ClienteController::class, 'configuracion'])->name('configuracion');
Route::post('/configuracion/update',[ClienteController::class, 'updateConfiguracion'])->name('cliente.configuracion.update');
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
Route::get('/logout', [AdminController::class, 'logout']);

//admin
Route::middleware(['admin'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'home']);
    Route::get('/dashboard_admin', [AdminController::class, 'dashboard']);
    Route::get('/ver_usuarios', [UsuarioController::class, 'ver_usuarios']);
    Route::get('/ver_envios', [UsuarioController::class, 'ver_envios']);
    Route::get('/ver_pagos', [UsuarioController::class, 'ver_pagos']);
    Route::get('/logout_admin', [AdminController::class, 'logout']);

//admin - clientes
Route::get('/ver_clientes', [ClienteController::class, 'ver_clientes']);
Route::post('/guardar_cliente', [ClienteController::class, 'guardar_cliente']);
Route::post('/editar_cliente/{id}', [ClienteController::class, 'editar_cliente']);
Route::get('/eliminar_cliente/{id}', [ClienteController::class, 'eliminar_cliente']);

//admin - leads
Route::get('/ver_leads', [AdminController::class, 'ver_leads']);
});

//cliente
Route::get('/home_cliente', [ClienteController::class, 'home']);
Route::get('/ver_ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/agregar_venta', [VentaController::class, 'agregar_venta']);
Route::post('/ventas/store', [VentaController::class, 'store'])->name('ventas.store');

Route::get('/buscar-cliente',[VentaController::class, 'buscarCliente'])->name('buscar.cliente');

//almacenes
Route::get('/almacen', [AlmacenController::class, 'index'])->name('almacen.index');
Route::post('/almacen/store', [AlmacenController::class, 'store'])->name('almacen.store');
Route::post('/almacen/update/{id}', [AlmacenController::class, 'update'])->name('almacen.update');
Route::get('/almacen/delete/{id}', [AlmacenController::class, 'destroy'])->name('almacen.delete');
Route::get('/almacen/productos/{id}', [AlmacenController::class, 'productos'])->name('almacen.productos');
Route::get('/almacenes/por-zona/{id}', [AlmacenController::class, 'porZona']);
//zonas
Route::get('/zonas', [ZonaController::class, 'index'])->name('zonas.index');
Route::post('/zonas/store', [ZonaController::class, 'store'])->name('zonas.store');
Route::put('/zonas/update/{id}', [ZonaController::class, 'update'])->name('zonas.update');
Route::delete('/zonas/delete/{id}', [ZonaController::class, 'destroy'])->name('zonas.destroy');

//documentos
Route::get('/documentos', [DocumentosController::class, 'index'])->name('documentos.index');
Route::post('/documentos/store', [DocumentosController::class, 'store'])->name('documentos.store');
Route::put('/documentos/update/{id}', [DocumentosController::class, 'update'])->name('documentos.update');
Route::delete('/documentos/delete/{id}', [DocumentosController::class, 'destroy'])->name('documentos.destroy');
Route::get('/documentos/ver/{id}', [DocumentosController::class, 'ver'])->name('documentos.ver');
Route::get('/documentos/download/{id}', [DocumentosController::class, 'download'])->name('documentos.download');
Route::resource('documentos', DocumentosController::class);

//envios 
Route::get('/ventas/{id}',   [VentaController::class, 'show'])->name('ventas.show');
Route::get('/ventas/{id}/pdf', [VentaController::class, 'pdf'])->name('ventas.pdf');
// =========================
// PASO 1 - REGISTRO
// =========================

Route::get('/ventas/create',[VentaController::class, 'create'])->name('ventas.create');
Route::post('/ventas/store',[VentaController::class, 'store'])->name('ventas.store');

// =========================
// PASO 2 - COSTOS
// =========================
Route::get('/ventas/{id}/costos',[VentaController::class, 'costos'])->name('ventas.costos');

Route::post('/ventas/{id}/guardar-costos', [VentaController::class, 'guardarCostos'])->name('ventas.guardar.costos');

// =========================
// PASO 3 - TRACKING
// =========================

Route::get('/ventas/{id}/tracking',[VentaController::class, 'tracking'])->name('ventas.tracking');

Route::post('/ventas/{id}/guardar-tracking',[VentaController::class, 'guardarTracking'])->name('ventas.guardar.tracking');
// =========================
// PASO 4 - DAM / ADUANAS
// =========================
Route::get('/ventas/{id}/dam',[VentaController::class, 'dam'])->name('ventas.dam');
Route::post('/ventas/{id}/dam', [VentaController::class, 'guardarDam'])->name('ventas.guardar.dam');
Route::post('/ventas/{id}/dam/costo', [VentaController::class, 'guardarCostoDam'])->name('ventas.guardar.costo.dam');
// =========================
// PASO 5 - CONFIRMACIÓN
// =========================
Route::get('/ventas/{id}/confirmacion',[VentaController::class, 'confirmacion'])->name('ventas.confirmacion');
// =========================
// AJAX
// =========================
Route::get('/almacenes/por-zona/{id}',[VentaController::class, 'almacenesPorZona']);
Route::get('/buscar-cliente',[VentaController::class, 'buscarCliente'])->name('buscar.cliente');
Route::get('/envios/{id}/detalle', [EnvioController::class, 'detalle'])->name('envios.detalle');
Route::post('/obtener-precio', [PrecioController::class, 'obtenerPrecio'])->name('obtener.precio');

//precios
Route::get('precios',[PrecioController::class,'index'])->name('precios.index');

Route::post('precios/store',[PrecioController::class,'store'])->name('precios.store');

Route::put('precios/update/{id}',[PrecioController::class,'update'])->name('precios.update');

Route::delete('precios/delete/{id}',[PrecioController::class,'destroy'])->name('precios.destroy');

//chat

Route::get('/chat/cliente', [ChatController::class, 'vistaCliente']);

Route::get('/chat/admin', [ChatController::class, 'vistaAdmin']);
Route::get('/chat/conversaciones', [ChatController::class, 'conversaciones']);
Route::get('/chat/mensajes/{id}', [ChatController::class, 'mensajes']);
Route::post('/chat/enviar', [ChatController::class, 'enviar']);
// opcional performance
Route::get('/chat/nuevos/{id}/{ultimo}', [ChatController::class, 'nuevos']);
//rollback
Route::post('/rollback', [RollbackController::class, 'rollback']);

//solicitud
Route::get('/solicitudes',[SolicitudController::class,'index_cliente'])->name('solicitudes');
Route::get('/solicitudes/nueva',[SolicitudController::class,'create_cliente']);
Route::post('/solicitudes',[SolicitudController::class,'store']);
Route::get('/operador/solicitudes',[SolicitudController::class,'indexOperador']);
Route::get('/solicitudes/ver/{id}',[SolicitudController::class,'ver'])->name('solicitudes.ver');
Route::post('/operador/solicitudes/procesar',[SolicitudController::class,'procesar']);
Route::post('/cliente/solicitudes',[SolicitudController::class,'post_procesar_solicitud_cliente']);

Route::get('/admin/solicitudes/{id}',[SolicitudController::class,'ver'])->name('solicitudes.ver');
Route::get('/admin/solicitudes/{id}/estado', [SolicitudController::class,'estado'])->name('solicitudes.estado');
Route::post('/admin/solicitudes/actualizar-estado',[SolicitudController::class,'actualizarEstado'])->name('solicitudes.actualizarEstado');
Route::post('/solicitudes/ajax/estado',[SolicitudController::class,'actualizarEstadoAjax'])->name('solicitudes.ajax.estado');


//solictud contraseña
Route::get('/recuperar_contraseña',[SolicitudController::class,'recuperar_password']);
Route::post('/solicitar-cambio-password',[SolicitudController::class,'solicitar_cambio_password'])->name('password.solicitar');
Route::get('/admin/cambios-password',[SolicitudController::class,'index_admin_password'])->name('password.index');
Route::get('/admin/cambios-password/{id}/aprobar',[SolicitudController::class,'aprobar'])->name('password.aprobar');
Route::get('/admin/cambios-password/{id}/rechazar',[SolicitudController::class,'rechazar'])->name('password.rechazar');