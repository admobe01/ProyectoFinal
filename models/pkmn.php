<?php

abstract class pkmn {

    protected ?int $id = null;
    protected string $nombre;
    protected string $tipo1;
    protected ?string $tipo2;
    protected array $stats = [
        'hp' => 0,
        'ataque' => 0,
        'defensa' => 0,
        'ataqueEspecial' => 0,
        'defensaEspecial' => 0,
        'velocidad' => 0,
    ];
    protected string $rareza;
    protected bool $shiny;

    public function __construct(string $nombre, string $tipo1, ?string $tipo2 = null){
        $this -> nombre = $nombre;
        $this -> tipo1 = $tipo1;
        $this -> tipo2 = $tipo2;
        $this -> rareza = $this -> getRarezaNombre();
        $this ->AsignarStats();
        $this -> shiny = $this -> isShiny();

    }
    abstract protected function getPuntosClase();
    abstract protected function isShiny();
    abstract protected function getRarezaNombre();

    public function getId() {return $this -> id;}
    public function setId(int $id) {$this -> id = $id;}
    public function setNombre(string $nombre) {$this -> nombre = $nombre;}
    public function getTipo1() {return $this -> tipo1;}
    public function getTipo2() {return $this -> tipo2;}
    public function getShiny() {return $this -> shiny;}
    public function getRareza() {return $this -> rareza;}
    public function getNombre() {return $this -> nombre;}
    public function getStats() { return $this -> stats;}
    public function setDatosRelatados(int $id, array $stats, bool $shiny, string $rareza) {
        $this->id = $id;
        $this->stats = $stats;
        $this->shiny = $shiny;
        $this->rareza = $rareza;
    } //Esto se usa para evitar que se generen nuevos stats, rareza y shiny cuando se listan los objetos

    private function  AsignarStats(){
        $totalPuntos = $this -> getPuntosClase();
        $minimoPorStats = 40;
        
        foreach($this -> stats as $y => $valor){

            $this -> stats[$y]  = $minimoPorStats;
        }

    $puntosRestantes = $totalPuntos - ($minimoPorStats * 6);

    $arrayKeys = array_keys($this -> stats);

        while ($puntosRestantes > 0) {

            $selecRndm = $arrayKeys[array_rand($arrayKeys)];

            $puntos = min(rand(4,5), $puntosRestantes);
            $this -> stats[$selecRndm] += $puntos;
            $puntosRestantes -= $puntos;
        }

    }

    public static function crear(string $nombre, string $t1, ?string $t2 = null){
        $ind = rand(1,100);
        if ($ind <= 80 ) {

            return new pkmnComun($nombre, $t1, $t2);
        } elseif ($ind <= 89 ) {
                return new pkmnPseudoLegendario($nombre, $t1, $t2);
            } elseif ($ind <= 95) {
                    return new pkmnMitico($nombre, $t1, $t2);
                }else {
                        return new pkmnLegendario($nombre, $t1, $t2);
                    }
    }

}
?>