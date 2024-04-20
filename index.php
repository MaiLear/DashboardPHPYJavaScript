<?php
$baseRoute = $_GET['url'] ?? 'Home/index';
$arrayBaseRoute = explode('/', $baseRoute);
$controller = $arrayBaseRoute[0];
$method = !empty($arrayBaseRoute[1]) && $arrayBaseRoute[1] != "" ? $arrayBaseRoute[1] : 'index';
$parameter = '';

if (!empty($arrayBaseRoute[2]) && $arrayBaseRoute[2] != "") {
    for ($i = 2; $i < count($arrayBaseRoute); $i++) {
        $parameter .= $arrayBaseRoute[$i] . ',';
    }
    //La funcion rtrim() elimina espacio en blancos y otros caracteres del lado derecho de la cadena. Tambien existen ltrim() y trim()
    $parameter = rtrim($parameter, ',');
}

require_once 'Config/App/autoload.php';
$controller = $controller . 'Controller';
$directoryController = "Controllers/$controller" . '.php';
if (file_exists($directoryController)) {
    require_once $directoryController;
    $controller = new $controller;

    if (method_exists($controller, $method)) {
        $controller->$method($parameter);
    } else {
        echo 'No exists method';
    }
} else {
    echo 'Not exists Controller';
}
