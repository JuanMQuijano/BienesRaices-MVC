<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


require 'funciones.php';
require 'config/database.php';

//Conectarnos a la BD
$db = conectarDB();

use Model\ActiveRecord;
use Dotenv\Dotenv;

ActiveRecord::setDB($db);
