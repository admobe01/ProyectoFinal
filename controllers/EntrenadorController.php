<?php
class EntrenadorController {
    private $gestor;

    public function __construct($gestor) {
        $this->gestor = $gestor;
    }

public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['usuario'];
        $passPlana = $_POST['password'];

        $entrenador = $this->gestor->buscarEntrenadorPorNombre($user);

        if ($entrenador && password_verify($passPlana, $entrenador->getPassword())) {

            $_SESSION['entrenador_id'] = $entrenador->getId();
            $_SESSION['entrenadorNombre'] = $entrenador->getUsuario(); 
            $_SESSION['es_admin'] = $entrenador->getEsAdmin();

            header("Location: index.php");
            exit;
        } else {
            $error = "Nombre de usuario o contraseña incorrectos.";
        }
    }
    include "views/login.php";
}

    public function alta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $nuevoE = new Entrenador($_POST['usuario'], $passwordHash);
            
            if ($this->gestor->registrarEntrenador($nuevoE)) {
                header("Location: index.php?accion=login");
                exit;
            }
        }
        include "views/alta_entrenador.php";
    }

    public function logout() {
        // Vaciamos y destruimos la sesión
        $_SESSION = [];
        session_destroy();
        
        header("Location: index.php");
        exit;
    }
}