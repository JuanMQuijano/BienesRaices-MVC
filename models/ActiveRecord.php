<?php

namespace Model;

class ActiveRecord
{
    //Base de datos
    protected static $database;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    //Definir la conexion a la DB
    public static function setDB($database)
    {
        self::$database = $database;
    }

    public function crear()
    {
        //SANITIZAMOS LOS DATOS
        $atributos = $this->sanitizarAtributos();

        //INSERTAMOS EN LA BASE DE DATOS
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        //Self porque el atributo $database es estatico
        $resultado = self::$database->query($query);

        if ($resultado) {
            //Redireccionamos al usuario despues de enviar el formulario

            //La función header se utiliza para redireccionar al usuario, es uno de sus tantos usos
            header('Location: /admin?resultado=1');
            //El header solo funciona si no hay.php antes
        }
    }

    public function guardar()
    {
        if (!is_null($this->id)) { //Para actualizar no debe estar en null
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function actualizar()
    {
        //SANITIZAMOS LOS DATOS
        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= "WHERE id = '" .  self::$database->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$database->query($query);

        if ($resultado) {
            //Redireccionamos al usuario despues de enviar el formulario

            //La función header se utiliza para redireccionar al usuario, es uno de sus tantos usos
            header('Location: /admin?resultado=2');
            //El header solo funciona si no hay.php antes
        }
    }

    //Identificar y unir las columnas de las bd
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            //Cuando se cumpla esta condición la omite y va al siguiente arreglo del foreach
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizarAtributos()
    {
        //Obtenemos los atributos
        $atributos = $this->atributos();
        $sanitizado = [];

        //Obtenemos el key y el value de cada uno de los atributos
        foreach ($atributos as $key => $value) {
            //Por cada KEY, escapamos el valor para sanitizarlo y lo agregamos al arreglo de sanitizado
            $sanitizado[$key] = self::$database->escape_string($value);
        }

        return $sanitizado;
    }

    //Validacion
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //Subida de archivos
    public function setImagen($imagen)
    {
        //Elimina la imagen previa
        if (!is_null($this->id)) { //En caso de que haya un ID
            $this->borrarImagen();
        }

        //Asignar al atributo de imagen, el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Lista todas las propiedades
    public static function selectAll()
    {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Obtiene determinado número de registros
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function consultarSQL($query)
    {
        //Consultar la BD
        $resultado = self::$database->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            //Transformamos los registros en objetos y los almacenamos en el array
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    public static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Lista propiedad en base al id
    public static function selectByID($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSQL($query);
        

        return array_shift($resultado);
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) { //Revisa de un objeto que un atributo exista
                $this->$key = $value;
            }
        }
    }

    //Eliminar un registro
    public function eliminar()
    {
        //Elimina la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$database->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$database->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    public function borrarImagen()
    {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
}
