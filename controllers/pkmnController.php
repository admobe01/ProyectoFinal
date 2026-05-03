<?php

class PkmnController {

    private $gestorControl;

    public function __construct($gestorOG) {
        $this->gestorControl = $gestorOG;
    }

public function index() {
    $porPagina = 8;
    
    // Detectar la página actual desde la URL 
    $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($paginaActual < 1) $paginaActual = 1; // Evitamos páginas negativas

    // Si estamos en la pág 1: (1-1) * 8 = 0 (empezamos desde el primer registro)
    $offset = ($paginaActual - 1) * $porPagina;

    $pkmn = $this->gestorControl->listar($porPagina, $offset);
    
    $totalPkmn = $this->gestorControl->contarTotal();
    $totalPaginas = ceil($totalPkmn / $porPagina); // ceil redondea hacia arriba 
    include "views/listar.php";
}

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $tipo1 = $_POST['tipo1'];
            $tipo2 = (!empty($_POST['tipo2']) && $_POST['tipo2'] !== $tipo1) ? $_POST['tipo2'] : null;            
            
            $pkmn = Pkmn::crear($nombre, $tipo1, $tipo2);
            $this->gestorControl->agregar($pkmn, $_SESSION['entrenador_id']);

            $totalPkmn = $this->gestorControl->contarTotal();
            $porPagina = 8;
            $ultimaPagina = ceil($totalPkmn / $porPagina); // Calculamos cuál es la última

            // Redirigimos específicamente a esa página
            header("Location: index.php?page=" . $ultimaPagina);
            exit;
        }

        include "views/crear.php";
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        $paginaOrigen = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Capturamos la página
        
        $idLogueado = $_SESSION['entrenador_id'] ?? null;
        $esAdmin = $_SESSION['es_admin'] ?? 0;

        $pkmn = $this->gestorControl->buscar($id);

        if ($pkmn == null) {
            header("Location: index.php?page=" . $paginaOrigen);
            exit;
        }

        if ($pkmn->getEntrenadorId() != $idLogueado && $esAdmin == 0) {
            header("Location: index.php?error=sin_permiso&page=" . $paginaOrigen);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pkmn->setNombre($_POST['nombre']);
            $this->gestorControl->modificar($pkmn);

            // Al terminar, volvemos exactamente a la página donde estábamos
            header("Location: index.php?page=" . $paginaOrigen);
            exit;
        }
        

        include "views/editar.php";
    }

public function eliminar() {
    if (!isset($_SESSION['entrenador_id'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    $idABorrar = $_GET['id'] ?? null;
    $idLogueado = $_SESSION['entrenador_id'];
    $esAdmin = $_SESSION['es_admin'] ?? 0; 
    
    // Capturamos la página de la que viene el usuario
    $paginaOrigen = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $pokemon = $this->gestorControl->buscar($idABorrar);

    if ($pokemon) {
        // Verificamos la propiedad O si es Administrador
        if ($pokemon->getEntrenadorId() == $idLogueado || $esAdmin == 1) {
            $this->gestorControl->eliminar($idABorrar, $idLogueado, $esAdmin);
        }
    }

    $totalRestante = $this->gestorControl->contarTotal();
    $totalPaginasNuevas = ceil($totalRestante / 8);

    if ($paginaOrigen > $totalPaginasNuevas && $totalPaginasNuevas > 0) {
        $paginaOrigen = $totalPaginasNuevas;
    }

    // Redirección con el parámetro de página
    header("Location: index.php?page=" . $paginaOrigen);
    exit;
}
    public function cambiarColor() {
    if (isset($_GET['color'])) {
        $colorSeleccionado = $_GET['color'];
            
            setcookie(
            "pokedex_color", 
            $colorSeleccionado, 
            [
                'expires' => time() + (86400 * 30),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );
    }
    header("Location: index.php");
    exit;
}
}
?>