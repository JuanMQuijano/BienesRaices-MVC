<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include  TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado()
{
    //Es necesario el session_start() siempre para validar los datos de la superglobal $_SESSION
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /');
    }
}

function debuguear($elemento)
{
    echo "<pre>";
    var_dump($elemento);
    echo "</pre>";
    exit;
}

//Escapa /Sanitiza el HTML
function s($html): string
{
    $s = strip_tags($html);
    return $s;
}

//Validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

//Muestra las alertas
function mostrarAlertas($resultado)
{
    $mensaje = '';

    switch ($resultado) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar(string $url)
{
    $id = $_GET['id'];
    //Validar, validamos que los datos sean del tipo requerido
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: ${url}");
    }

    return $id;
}
