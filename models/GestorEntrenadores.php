<?php
class GestorEntrenadores {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance()->getConn();
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

    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) { //este if hace la funcion de que si $res existe se ejecute su codigo, el cual es una variable que se acaba de crear
        return new Entrenador($res['usuario'], $res['password'], (int)$res['id'], (int)$res['es_admin']);
    }
    return false;
}
}