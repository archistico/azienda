<?php

namespace App\Model\Risposta;

class Risposte {

    public $lista;
    
    public function __construct() {
        $this->lista = [];
    }

    public function Aggiungi($elemento) {
        $this->lista[] = $elemento;
    }

    public function SetLista(array $lista) {
        $this->lista = $lista;
        return $this;
    }

    public function GetLista() {
        return $this->lista;
    }
}