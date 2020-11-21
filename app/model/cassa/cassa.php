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

    public function ControllaQuantitaInCassa(float $quantita) {
        if($this->cassa >= $quantita) {
            return true;
        } else {
            return false;
        }
    }

    public function Deposita(float $denaro) {
        $this->cassa += $denaro;
    }

    public function Preleva(float $denaro) {
        $this->cassa -= $denaro;
    }
}