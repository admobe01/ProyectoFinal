<?php
require_once "autoload.php";
session_start();

// 1. Instanciamos los gestores y controladores (Nombres exactos de tu ZIP)
$gestorPkmn = new GestorPDO();
$gestorEntrenador = new GestorEntrenadores();

$pController = new PkmnController($gestorPkmn);
$eController = new EntrenadorController($gestorEntrenador);

$accion = $_GET['accion'] ?? 'index';

// --- LÓGICA DE COOKIES: RE-AUTENTICACIÓN AUTOMÁTICA (Arreglo Punto 4) ---
// Si NO hay sesión, pero SÍ existe la cookie del entrenador
if (!isset($_SESSION['entrenador_id']) && isset($_COOKIE['entrenador_login'])) {
    
    // Recuperamos el nombre de usuario guardado en la cookie (Base64)
    $userRecuperado = base64_decode($_COOKIE['entrenador_login']);
    
    // IMPORTANTE: Usamos tu método real de GestorEntrenadores.php
    $entrenador = $gestorEntrenador->buscarEntrenadorPorNombre($userRecuperado);
    
    if ($entrenador) {
        $_SESSION['entrenador_id'] = $entrenador->getId();
        $_SESSION['entrenadorNombre'] = $entrenador->getUsuario();
    } else {
        // Si la cookie es inválida, la borramos
        setcookie('entrenador_login', '', time() - 3600, '/');
    }
}
// ----------------------------------------------------------------------

switch ($accion) {
    // Gestión de usuarios (Entrenadores)
    case 'login':
        $eController->login();
        break;
    case 'alta':
        $eController->alta();
        break;
    case 'logout':
        $eController->logout();
        break;

    // Gestión de Pokémon: Acciones que requieren estar LOGUEADO
    case 'crear':
    case 'editar':
    case 'eliminar': // Ahora incluimos eliminar aquí por seguridad
        if (!isset($_SESSION['entrenador_id'])) {
            header('Location: index.php?accion=login');
            exit;
        }
        
        // Si está autenticado, ejecutamos la acción del controlador de Pkmn
        if ($accion === 'crear') $pController->crear();
        if ($accion === 'editar') $pController->editar();
        if ($accion === 'eliminar') $pController->eliminar();
        break;

    default:
        $pController->index();
        break;
}