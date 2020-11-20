<?php

namespace App\Model\Cassa;

class Cassa {

    public $cassa;
    
    public function __construct($cassa = 0) {
        $this->cassa = $cassa;
    }

    public function GetCassaFormattato() {
        return "€ " . number_format($this->cassa, 2, ',', ' ');
    }

    public function Deposita($denaro) {
        $this->cassa += $denaro;
    }

    public function Preleva($denaro) {
        $this->cassa -= $denaro;
    }
}