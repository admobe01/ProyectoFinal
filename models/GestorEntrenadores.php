<?php
class GestorEntrenadores {
    private $db;

    public function __construct() {
        $this->db = connection::getInstance()->getConn();
    }

    public function registrarEntrenador(Entrenador $e): bool {
        try {
            $sql = "INSERT INTO entrenadores (usuario, password) VALUES (:user, :pass)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user', $e->getUsuario());
            $stmt->bindValue(':pass', $e->getPassword());
            return $stmt->execute();
        } catch (PDOException $y) {
            return false;
        }
    }

    public function buscarEntrenadorPorNombre(string $nombreUsuario) {
        $sql = "SELECT * FROM entrenadores WHERE usuario = :user";
        $stmt = $this -> db -> prepare($sql);
        $stmt->bindValue(':user', $nombreUsuario);
        $stmt->execute();

        if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Entrenador($res['usuario'], $res['password'], (int)$res['id']);
        }
        return false;
    }
}