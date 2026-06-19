<?php

use CodeIgniter\Router\RouteCollection;

   
    $routes->post('auditoria/registrar', 'AuditoriaController::registrar');
    $routes->get('auditoria/registrar', 'AuditoriaController::registrar');
    $routes->post('api/auditoria/rollback','AuditoriaController::rollback');

    $routes->get('repositorio', 'RepositorioController::index');
    $routes->get('repositorio/editar', 'RepositorioController::editar');
    $routes->post('repositorio/guardar', 'RepositorioController::guardar');


    $routes->get('/', 'LoginController::index');
    $routes->get('/login', 'LoginController::index');
    $routes->post('/login/validar', 'LoginController::validar');

    $routes->get('/logout', 'LoginController::logout');
    $routes->get('/logout_usuario', 'LoginController::logout_usuario');

    $routes->get('admin', 'AdminController::index');
    $routes->post('admin/guardarUsuario','AdminController::guardarUsuario');
    $routes->get('admin/crearBackup','AdminController::crearBackup');
    $routes->get('admin/restaurarBackup/(:num)','AdminController::restaurarBackup/$1');