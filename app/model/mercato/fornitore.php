<?php

namespace App\Model\Mercato;

class Fornitore {

    public function __construct(\App\Model\Prodotto\Prodotto $prodotto) {
        $this->prodotto = $prodotto;
    }

    public function Vendi(\App\Model\Prodotto\Prodotto $prodotto, int $quantita) {
        if(($this->prodotto->nome == $prodotto->nome) && ($this->prodotto->costo == $prodotto->costo)) {
            return true;
        } else {
            return false;
        }
    }
}