<?php

class GestorPDO {
    private $db;

    public function __construct(){
        $this -> db = Connection::getInstance()->getConn();
    }

// Añadimos parámetros con valores por defecto (8 por página, empezando desde el principio)
public function listar($limite = 8, $offset = 0) {
    $arrayPkmn = [];
    
    // Cambiamos query() por prepare() para poder usar parámetros de forma segura
    $consulta = "SELECT * FROM pokemon LIMIT :limite OFFSET :offset";
    $stmt = $this->db->prepare($consulta);

    // CRÍTICO: LIMIT y OFFSET necesitan ser tratados como enteros (PARAM_INT)
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();

    while ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombreClase = "Pkmn" . ucfirst(strtolower($value['rareza'])); 
        $p = new $nombreClase($value['nombre'], $value['tipo1'], $value['tipo2']);

        $statsRecuperados = [
            'hp' => $value['hp'],
            'ataque' => $value['ataque'],
            'defensa' => $value['defensa'],
            'ataqueEspecial' => $value['ataque_esp'],
            'defensaEspecial' => $value['defensa_esp'],
            'velocidad' => $value['velocidad']
        ];

        $p->setDatosRelatados(
            $value['id'], 
            $statsRecuperados, 
            $value['shiny'], 
            $value['rareza'], 
            $value['entrenador_id'] 
        );

        $arrayPkmn[] = $p;
    }
    return $arrayPkmn;
}

public function contarTotal() {
    $consulta = "SELECT COUNT(*) FROM pokemon";
    $resultado = $this->db->query($consulta);
    return $resultado->fetchColumn(); // Devuelve el número total de filas
}

public function agregar(pkmn $p, int $idEntrenador) {
    try {

        $sql = "INSERT INTO pokemon (nombre, tipo1, tipo2, hp, ataque, defensa, ataque_esp, defensa_esp, velocidad, rareza, shiny, entrenador_id) 
                VALUES (:nom, :t1, :t2, :hp, :atq, :def, :atq_esp, :def_esp, :vel, :rar, :shi, :eid)";
        
        $stmt = $this->db->prepare($sql);

        $stats = $p->getStats();

        $stmt->bindValue(':nom', $p->getNombre());
        $stmt->bindValue(':t1', $p->getTipo1());
        $stmt->bindValue(':t2', $p->getTipo2(), $p->getTipo2() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':hp', $stats['hp']);
        $stmt->bindValue(':atq', $stats['ataque']);
        $stmt->bindValue(':def', $stats['defensa']);
        $stmt->bindValue(':atq_esp', $stats['ataqueEspecial']);
        $stmt->bindValue(':def_esp', $stats['defensaEspecial']);
        $stmt->bindValue(':vel', $stats['velocidad']);
        $stmt->bindValue(':rar', $p->getRareza());
        $stmt->bindValue(':shi', $p->getShiny(), PDO::PARAM_BOOL);
        $stmt->bindValue(':eid', $idEntrenador, PDO::PARAM_INT);

        return $stmt->execute();

    } catch (PDOException $e) {
        return false;
    }
}

public function buscar($id) {
    $sql = "SELECT * FROM pokemon WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    if ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Reconstruimos el objeto según su rareza
        // Nota: Asegúrate de que $value['rareza'] coincida con tus clases (Comun, Legendario, etc.)
        $nombreClase = "Pkmn" . ucfirst($value['rareza']); 

        $p = new $nombreClase($value['nombre'], $value['tipo1'], $value['tipo2']);
        
        $stats = [
            'hp' => $value['hp'],
            'ataque' => $value['ataque'],
            'defensa' => $value['defensa'],
            'ataqueEspecial' => $value['ataque_esp'],
            'defensaEspecial' => $value['defensa_esp'],
            'velocidad' => $value['velocidad']
        ];

        $p->setDatosRelatados(
            $value['id'], 
            $stats, 
            $value['shiny'], 
            $value['rareza'], 
            $value['entrenador_id']
        );
        
        return $p;
    }
    return null;
}

    public function eliminar($id, $idEntrenador, $esAdmin = 0) {
        if ($esAdmin == 1) {
            // Si es admin, borramos sin importar el dueño
            $sql = "DELETE FROM pokemon WHERE id = :id";
            $stmt = $this->db->prepare($sql);
        } else {
            // Si no es admin, filtramos por id de entrenador para seguridad
            $sql = "DELETE FROM pokemon WHERE id = :id AND entrenador_id = :eid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':eid', $idEntrenador);
        }

        // El ID siempre se vincula, sea admin o no
        $stmt->bindValue(':id', $id);
        
        return $stmt->execute();
    }
    public function modificar(pkmn $p) {
    // Lo unico razonable a editar es su mote
    $sql = "UPDATE pokemon SET nombre = :nom WHERE id = :id";
    $stmt = $this -> db -> prepare($sql);
    $stmt -> bindValue(':nom', $p->getNombre());
    $stmt -> bindValue(':id', $p->getId());
    return $stmt->execute();
}

}

?>