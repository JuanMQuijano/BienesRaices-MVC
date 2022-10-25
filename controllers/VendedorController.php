<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{

    public static function crearVendedor(Router $router)
    {
        $vendedor = new Vendedor;
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            //Validamos que no hayan campos vacios
            $errores = $vendedor->validar();

            //No hay errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->view('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizarVendedor(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::selectByID($id);
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los valores
            $args = $_POST['vendedor'];

            //Sincronizar objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);

            //Validacion
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->view('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminarVendedor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    if ($tipo === 'vendedor') {
                        $vendedor = Vendedor::selectByID($id);
                        $vendedor->eliminar();
                    }
                }
            }
        }
    }
}
