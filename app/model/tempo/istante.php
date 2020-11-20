<?php

namespace App\Model\Tempo;

class Istante {

    public $inizio;
    public $fine;
    
    public function __construct($inizio, $fine) {
        $this->inizio = $inizio;
        $this->fine = $fine;
    }

    public function GetIstante() {
        return $this->inizio . "-" . $this->fine;
    }
}