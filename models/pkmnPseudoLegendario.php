<?php
class PkmnPseudoLegendario extends Pkmn {

    protected function getPuntosClase() {return 550;}
    protected function getRarezaNombre(){ return "PseudoLegendario";}
    protected function isShiny(){
        $num = rand(1,100);
        if ($num <= 8) {return true;}
        else {return false;}
    }
}

?>