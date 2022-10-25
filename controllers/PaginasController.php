<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{

    public static function home(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->view('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->view('paginas/nosotros');
    }

    public static function blog(Router $router)
    {
        $router->view('paginas/blog');
    }

    public static function propiedades(Router $router)
    {

        $propiedades = Propiedad::selectAll();
        $router->view('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');

        $propiedad = Propiedad::selectByID($id);

        $router->view('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function entrada(Router $router)
    {
        $router->view('paginas/entrada');
    }

    public static function contacto(Router $router)
    {
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $respuestas = $_POST['contacto'];

            //INSTANCIAMOS PHPMAILER
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '5154805a4e3146';
            $mail->Password = '749efa6fe2b819';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Configurar el contenido del EMAIL

            $mail->setFrom('admin@bienesraices.com'); //Quien envia el email
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //Quien recibe el email
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un Nuevo Mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

            //Enviar de forma condicional algunos campos de email o telefono

            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por TELÉFONO</p>';

                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha y Hora: ' . $respuestas['fecha'] . ' ' . $respuestas['hora'] . '</p>';
            } else {
                $contenido .= '<p>Eligió ser contactado por EMAIL</p>';
                $contenido .= '<p>E-mail: ' . $respuestas['email'] . '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Contacto: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;

            //Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje =  "El mensaje no se pudo enviar";
            }
        }

        $router->view('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
