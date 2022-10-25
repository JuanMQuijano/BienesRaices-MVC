<?php

namespace Model;

class Admin extends ActiveRecord
{
    //Base de datos
    protected static $table = 'usuarios';
    protected static $columnasDB = ['ID', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = 'El email es obligatorio';
        }

        if (!$this->password) {
            self::$errores[] = 'La contraseña es obligatoria';
        }

        return self::$errores;
    }

    public function existeUsuario()
    {
        //Revisamos si el usuario existe o no
        $query = "SELECT * FROM " . self::$table . " WHERE EMAIL = '" . $this->email . "' LIMIT 1";

        $resultado = self::$database->query($query);

        if (!$resultado->num_rows) {
            self::$errores[] = 'El usuario no existe';
            return;
        }

        return $resultado;
    }

    public function verificarContraseña($resultado)
    {
        $usuario = $resultado->fetch_object();

        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$errores[] = 'El Password es incorrecto';
        }

        return $autenticado;
    }

    public function autenticar()
    {
        session_start();

        //Llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}
