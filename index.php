<?php
session_start();
require_once "autoload.php";

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
