<?php

namespace App\Model\Prodotto;

class Prodotto {

    public $nome;
    public $prezzo;
    public $costo;
    
    public function __construct(string $nome, float $costo, float $prezzo = 0) {
        $this->nome = $nome;
        $this->costo = $costo;
        $this->prezzo = $prezzo;
    }

    public function GetPrezzoFormattato() {
        return "€ " . number_format($this->prezzo, 2, ',', ' ');
    }

    public function GetPrezzo() {
        return $this->prezzo;
    }

    public function GetCosto() {
        return $this->costo;
    }
}