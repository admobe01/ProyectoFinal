<?php
require_once "autoload.php";
session_start();

// 1. Instanciamos los gestores y controladores
$gestorPkmn = new GestorPDO();
$gestorEntrenador = new GestorEntrenadores();

$pController = new PkmnController($gestorPkmn);
$eController = new EntrenadorController($gestorEntrenador);

$accion = $_GET['accion'] ?? 'index';

// --- LÓGICA DE COOKIES: RE-AUTENTICACIÓN AUTOMÁTICA ---
if (!isset($_SESSION['entrenador_id']) && isset($_COOKIE['entrenador_login'])) {
    $userRecuperado = base64_decode($_COOKIE['entrenador_login']);
    $entrenador = $gestorEntrenador->buscarEntrenadorPorNombre($userRecuperado);
    
    if ($entrenador) {
        $_SESSION['entrenador_id'] = $entrenador->getId();
        $_SESSION['entrenadorNombre'] = $entrenador->getUsuario();
        $_SESSION['es_admin'] = $entrenador->getEsAdmin();
    } else {
        setcookie('entrenador_login', '', time() - 3600, '/');
    }
}

// --- SISTEMA DE RUTAS ---
switch ($accion) {

    case 'login':
        $eController->login();
        break;
    case 'alta':
        $eController->alta();
        break;
    case 'logout':
        $eController->logout();
        break;

    case 'cambiarColor':
        $pController->cambiarColor();
        break;

    // 3. Gestión de Pokémon (Requieren estar logueado)
    case 'crear':
    case 'editar':
    case 'eliminar': 
        if (!isset($_SESSION['entrenador_id'])) {
            header('Location: index.php?accion=login');
            exit;
        }
        
        if ($accion === 'crear') $pController->crear();
        if ($accion === 'editar') $pController->editar();
        if ($accion === 'eliminar') $pController->eliminar();
        break;

    default:
        $pController->index();
        break;
}