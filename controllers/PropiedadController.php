<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::selectAll();
        $vendedores = Vendedor::selectAll();
        $resultado = $_GET['resultado'] ?? null;

        //Va a abrir un view con el contenido de propiedades/admin
        //Y con los datos que le pasemos en el arreglo
        $router->view('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crearPropiedad(Router $router)
    {
        $arreglo = ["titulo", "descripcion"];
        $propiedad = new Propiedad;
        $vendedores = Vendedor::selectAll();

        //Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($arreglo as $elemento) {
                $_POST['propiedad'][$elemento] = s($_POST['propiedad'][$elemento]);
            }
            //Instanciamos la propiedad, que recibe un arreglo como parametro
            $propiedad = new Propiedad($_POST['propiedad']); //Pasamos todo lo que esta en la url como parametro        

            //Generamos un nombre único para la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Setear la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                //Realiza un resize a la imagen con intervention
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            //Validamos los errores
            $errores = $propiedad->validar();

            //Revisamos que el arreglo de errores esté vacio
            if (empty($errores)) {
                /*** SUBIDA DE ARCHIVOS ***/

                //Si una carpeta existe o no
                if (!is_dir(CARPETA_IMAGENES)) {
                    //Si no existe, crearla
                    mkdir(CARPETA_IMAGENES);
                }

                //Guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                //Guarda en la bd
                $propiedad->guardar();
            }
        }

        $router->view('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizarPropiedad(Router $router)
    {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::selectByID($id);
        $vendedores = Vendedor::selectAll();

        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            $errores = $propiedad->validar();

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Revisamos que el arreglo de errores esté vacio
            if (empty($errores)) {

                //Validacion subida de archivos
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    //Realiza un resize a la imagen con intervention
                    $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                    $propiedad->setImagen($nombreImagen);
                    //Almacenar la imagen 
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }

        $router->view('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminarPropiedad()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    if ($tipo === 'propiedad') {
                        $propiedad = Propiedad::selectByID($id);

                        $propiedad->eliminar();
                    }
                }
            }
        }
    }
}
