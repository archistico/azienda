<?php

namespace App\Model\Magazzino;

use App\Model\Prodotto\Prodotto;

class Magazzino {

    public $lista;
    
    public function __construct() {
        $this->lista = [];
    }

    public function GetValoreMagazzinoFormattato() {
        $valore = 0;
        foreach($this->lista as $el) {
            $valore += $el->GetPrezzo();
        }
        return "€ " . number_format($valore, 2, ',', ' ');
    }

    public function Aggiungi(Prodotto $prodotto) {
        $this->lista[] = $prodotto;
    }

    public function Rimuovi(?Prodotto $prodotto) {
        if(is_null($prodotto)) {
            return;
        }
        $indice = array_search($prodotto, $this->lista);
        if($indice === false) {
            return;
        } else {
            array_splice($this->lista, $indice, 1);
        }
    }

    public function GetQuantiProdotti(Prodotto $prodotto) {
        $conteggio = 0;
        foreach($this->lista as $el) {
            if($el->nome == $prodotto->nome && $el->prezzo == $prodotto->prezzo) {
                $conteggio++;
            }
        }
        return $conteggio;
    }

    public function GetProdotto($indice) {
        if ($indice < count($this->lista)) {
            return $this->lista[$indice];
        } else {
            return null;
        }
    }
}