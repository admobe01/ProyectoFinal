<?php
require_once "autoload.php";
session_start();

$gestorOG=new GestorPDO();
$controller = new pkmnController($gestorOG);

$accion = $_GET['accion'] ?? 'index';

switch ($accion) {
    case 'crear':
        $controller->crear();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'eliminar':
        $controller->eliminar();
        break;
    default:
        $controller->index();
}
