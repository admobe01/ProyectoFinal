<?php
class pkmnComun extends pkmn {

    protected function getPuntosClase() {return 400;}
    protected function getRarezaNombre(){ return "Comun";}
    protected function isShiny(){
        $num = rand(1,100);
        if ($num <= 8) {return true;}
        else {return false;}
    }
}

?>