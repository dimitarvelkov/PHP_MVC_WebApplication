<?php
require_once("includes/config.php");
session_start();

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUriParts = explode('/', $requestPath);

$params = array_slice($requestUriParts,3);

$controllerName = DEFAULT_CONTROLLER;
$action = DEFAULT_ACTION;

if(count($requestUriParts)>=2 && $requestUriParts[1]!=""){
    $controllerName = $requestUriParts[1];
}

if(count($requestUriParts)>=3 && $requestUriParts[2]!=""){
    $action = $requestUriParts[2];
}

$controllerClassName = ucfirst($controllerName)."Controller";
$controllerFileName = "controllers/".$controllerClassName.".php";

if(class_exists($controllerClassName)) {
    $controller = new $controllerClassName($controllerName,$action);

    if (method_exists($controller, $action)) {
        call_user_func_array(array($controller,$action),$params);
        $controller->renderView();
    } else {
        die("there is no ".$action."  in this ".$controllerClassName);
    }
}else{
    die("there is no class with name ".$controllerClassName);
}

function __autoload($class_name) {
    if (file_exists("controllers/$class_name.php")) {
        include_once "controllers/$class_name.php";
    }
    if (file_exists("models/$class_name.php")) {
        include_once "models/$class_name.php";
    }
}

