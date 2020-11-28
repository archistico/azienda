<?php

namespace App\Model\Tasse;

class Iva {

    public $registro;
    public $aliquota = 0.22;

    public function __construct($registro = 0) {
        $this->registro = $registro;
    }

    public function GetRegistroFormattato() {
        return "€ " . number_format($this->registro, 2, ',', ' ');
    }

    public function CalcolaIva(float $prezzo) {
        $prezzo_scorporato = $prezzo / (1 + $this->aliquota);
        $iva = $prezzo - $prezzo_scorporato;
        return $iva;
    }

    public function GetIva() {
        return $this->registro;
    }

    public function SetRegistro(float $valore) {
        $this->registro = $valore;
    }

    public function CreditoAcquisto(float $prezzo) {
        $this->registro -= $this->CalcolaIva($prezzo);
    }

    public function DebitoVendita(float $prezzo) {
        $this->registro += $this->CalcolaIva($prezzo);
    }
}