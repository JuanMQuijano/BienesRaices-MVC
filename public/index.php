<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginasController;

$router = new Router();

// Especificación de la rutas, y de las funciones que llama cada una de ellas al ser abiertas en el navegador

//ZONA PUBLICA
$router->get('/', [PaginasController::class, 'home']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/anuncios', [PaginasController::class, 'anuncios']);
$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/propiedad', [PaginasController::class, 'propiedad']);
$router->get('/entrada', [PaginasController::class, 'entrada']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

//LOGIN Y AUTENTICACION
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);


//ZONA PRIVADA
$router->get('/admin', [PropiedadController::class, 'index']);

$router->get('/propiedades/crear', [PropiedadController::class, 'crearPropiedad']);
$router->post('/propiedades/crear', [PropiedadController::class, 'crearPropiedad']);

$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizarPropiedad']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizarPropiedad']);

$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminarPropiedad']);

$router->get('/vendedores/crear', [VendedorController::class, 'crearVendedor']);
$router->post('/vendedores/crear', [VendedorController::class, 'crearVendedor']);

$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizarVendedor']);
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizarVendedor']);

$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminarVendedor']);

$router->comprobarRutas();
