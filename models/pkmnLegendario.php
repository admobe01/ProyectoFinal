<?php
class pkmnLegendario extends pkmn {

    protected function getPuntosClase() {return 700;}
    protected function getRarezaNombre(){ return "Legendario";}
    protected function isShiny(){
        $num = rand(1,100);
        if ($num <= 3) {return true;}
        else {return false;}
    }
}

?>