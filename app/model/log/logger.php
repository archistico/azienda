<?php

namespace App\Model\Log;

use \App\Model\Log\Log;

class Logger {

    public $lista;
    
    public function __construct() {
        $this->lista = [];
    }

    public function Aggiungi(Log $log) {
        $this->lista[] = $log;
    }

    public function ToArray() {
        $risultato = [];

        foreach($this->lista as $log) {
            $elementi = [];
            foreach($log->lista as $element) {
                $elementi[] = $element;
            }
            $risultato[] = $elementi;
        }

        return $risultato;
    }
}