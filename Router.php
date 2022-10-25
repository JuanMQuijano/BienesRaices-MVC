<?php

namespace MVC;

class Router
{

    //Arreglos de rutas
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $funcion)
    {
        //Agrego las url y las funciones a su respectivo arreglo
        $this->rutasGET[$url] = $funcion;
    }

    public function post($url, $funcion)
    {
        //Agrego las url y las funciones a su respectivo arreglo
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas()
    {

        session_start();

        $auth = $_SESSION['login'] ?? null;

        //Arreglo de rutas protegidas
        $rutasProtegidas = [
            '/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear',
            '/vendedores/actualizar', '/vendedores/eliminar'
        ];


        //Compruebo las rutas obteniento la ruta actual y el metodo de envio
        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];

        //Si el metodo es GET, reviso que el arreglo de rutasGET tenga la ruta actual si no lo tiene el valor es null
        if ($metodo === 'GET') {
            $funcion = $this->rutasGET[$urlActual] ?? null;
        } else {
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        //Proteger las rutas
        if (in_array($urlActual, $rutasProtegidas) && !$auth) { //Si la urlActual está en el arreglo y el usuario no esta autenticado
            header('Location: /');
        }

        //Si la ruta existe y tiene una función mando a llamar esa función de caso contrario redirecciono a la pagina de 404
        if ($funcion) {
            call_user_func($funcion, $this);
        } else {
            echo "Página No Existe";
        }
    }

    //Muestra una vista
    public function view($view, $datos = [])
    {

        foreach ($datos as $key => $value) {
            $$key = $value; //Variables de variables
        }

        ob_start(); //Iniciar almacenamiento en memoria
        include __DIR__ . "/views/$view.php"; //Guardamos esta vista en memoria

        $contenido = ob_get_clean(); //Limpiamos el almacenamiento en memoria

        include __DIR__ . "/views/layout.php";
    }
}
