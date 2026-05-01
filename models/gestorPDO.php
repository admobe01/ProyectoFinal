<?php

class gestorPDO {
    private $db;

    public function __construct(){
        $this -> db = connection::getInstance()->getConn();
    }

    public function listar() {
    
    $arrayPkmn = [];

        $consulta = "SELECT * FROM pokemon";
        $rtdo=$this -> db -> query($consulta);

        while ($value = $rtdo->fetch(PDO::FETCH_ASSOC)) {
            $pkmn = "pkmn" . $value['rareza']; //Se busca la rareza del pkmn en el que este el fetch

            $p = new $pkmn($value['nombre'], $value['tipo1'] , $value['tipo2']); //creamos el objeto pero tiene stats aleatorios, no fieles a la bbdd

        //Se crea un array asociativo al cual con el setDatosRelatados vamos a pisarlos con los originales
        $statsRecuperados = [
            'hp' => $value['hp'],
            'ataque' => $value['ataque'],
            'defensa' => $value['defensa'],
            'ataqueEspecial' => $value['ataque_esp'],
            'defensaEspecial' => $value['defensa_esp'],
            'velocidad' => $value['velocidad']
        ];

        $p->setDatosRelatados($value['id'], $statsRecuperados, $value['shiny'], $value['rareza']);

        $arrayPkmn[] = $p;
        }
        return $arrayPkmn;
    }

    public function agregar(pkmn $p) {
    try {
        // Preparamos la consulta con los nombres de columnas de tu imagen
        $sql = "INSERT INTO pokemon (nombre, tipo1, tipo2, hp, ataque, defensa, ataque_esp, defensa_esp, velocidad, rareza, shiny) 
                VALUES (:nom, :t1, :t2, :hp, :atq, :def, :atq_esp, :def_esp, :vel, :rar, :shi)";
        
        $stmt = $this->db->prepare($sql);

        // Extraemos el array de stats que hemos preparado en el padre
        $stats = $p->getStats();

        $stmt -> bindValue(':nom', $p -> getNombre());
        $stmt -> bindValue(':t1', $p -> getTipo1());
        $stmt -> bindValue(':t2', $p -> getTipo2());
        $stmt -> bindValue(':hp', $stats['hp']);
        $stmt -> bindValue(':atq', $stats['ataque']);
        $stmt -> bindValue(':def', $stats['defensa']);
        
        $stmt->bindValue(':atq_esp', $stats['ataqueEspecial']);
        $stmt->bindValue(':def_esp', $stats['defensaEspecial']);
        
        $stmt->bindValue(':vel', $stats['velocidad']);
        $stmt->bindValue(':rar', $p -> getRareza());
        
        // Indicar a la bbdd que es tipo booleano
        $stmt->bindValue(':shi', $p->getShiny(), PDO::PARAM_BOOL);

        return $stmt->execute();

    } catch (PDOException $e) {
            return false;
        }
    }

    public function buscar($id) {
        $sql = "SELECT * FROM pokemon WHERE id = :id";
        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindvalue(':id', $id);
        $stmt -> execute();

        if ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // Reconstruimos el objeto según su rareza
        $nombreClase = "pkmn" . $value['rareza'];

        $p = new $nombreClase($value['nombre'], $value['tipo1'], $value['tipo2']);
        
        $stats = [
            'hp' => $value['hp'],
            'ataque' => $value['ataque'],
            'defensa' => $value['defensa'],
            'ataqueEspecial' => $value['ataque_esp'],
            'defensaEspecial' => $value['defensa_esp'],
            'velocidad' => $value['velocidad']
        ];
            $p -> setDatosRelatados($value['id'], $stats, $value['shiny'], $value['rareza']);
        return $p;
    }
    return null;
    }

    public function eliminar($id) {
    $sql = "DELETE FROM pokemon WHERE id = :id";
    $stmt = $this -> db -> prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt -> execute();
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