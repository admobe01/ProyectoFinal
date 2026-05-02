<?php

class PkmnController {

    private $gestorControl;

    public function __construct($gestorOG) {
        $this->gestorControl = $gestorOG;
    }

    public function index() {
        $pkmn = $this->gestorControl->listar();
        include "views/listar.php";
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $tipo1 = $_POST['tipo1'];
            $tipo2 = (!empty($_POST['tipo2']) && $_POST['tipo2'] !== $tipo1) ? $_POST['tipo2'] : null;            
            $pkmn = Pkmn::crear($nombre, $tipo1, $tipo2);
            $this->gestorControl->agregar($pkmn, $_SESSION['entrenador_id']);

            header("Location: index.php");
            exit;
        }

        include "views/crear.php";
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        $pkmn = ($this -> gestorControl -> buscar($id));

    if($pkmn == null) {
        header("Location: index.php");
        exit;
    }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $pkmn -> setNombre($_POST['nombre']);
            $this->gestorControl->modificar($pkmn);

            header("Location:index.php");
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

        $pokemon = $this->gestorControl->buscar($idABorrar);

        if ($pokemon) {
            // Verificamos la propiedad O si es Administrador
            if ($pokemon->getEntrenadorId() == $idLogueado || $esAdmin == 1) {
            $this->gestorControl->eliminar($idABorrar, $idLogueado, $esAdmin);
            }
        }

        header("Location: index.php");
        exit;
    }

    public function cambiarColor() {
    if (isset($_POST['color'])) {
        $colorSeleccionado = $_POST['color'];
        
        // Creamos la cookie (duración de 30 días como hizo el profesor)
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