<?php

namespace App\Model\Mercato;

use App\Model\Tempo\Istante;

class Acquirente {

    public function __construct() {
    }

    public function ControllaQuantitaInCassa(int $quantita) {
        return true;
    }

    public function Cicla(Istante $istante) {
        
    }
    
}