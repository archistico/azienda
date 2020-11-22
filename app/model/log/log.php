<?php

namespace App\Model\Log;

class Log {

    public $lista;
    
    public function __construct() {
        $this->lista = [];
    }

    public function Aggiungi(string $elemento) {
        $this->lista[] = $elemento;
    }

    public function SetLista(array $lista) {
        $this->lista = $lista;
    }
}