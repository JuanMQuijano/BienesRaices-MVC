<?php

function conectarDB()
{
    $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);

    if (!$db) {
        echo "Algo falló";
        exit;
    }

    return $db;
}

conectarDB();
