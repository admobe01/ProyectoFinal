<?php
class pkmnMitico extends pkmn {

    protected function getPuntosClase() {return 600;}
    protected function getRarezaNombre(){ return "Mitico";}
    protected function isShiny(){
        $num = rand(1,100);
        if ($num <= 5) {return true;}
        else {return false;}
    }
}

?>