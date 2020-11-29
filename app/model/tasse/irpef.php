<?php

namespace App\Model\Tasse;

class Irpef
{

    public $imponibile;
    public $aliquote = [
        [
            'min' => 0.00,
            'max' => 15000.00,
            'aliquota' => 0.23,
            'pagamentomax' => 3450.00,
        ],
        [
            'min' => 15000.01,
            'max' => 28000.00,
            'aliquota' => 0.27,
            'pagamentomax' => 3450.00,
        ],
        [
            'min' => 28000.01,
            'max' => 55000.00,
            'aliquota' => 0.38,
        ],
        [
            'min' => 55000.01,
            'max' => 75000.00,
            'aliquota' => 0.41,
        ],
        [
            'min' => 75000.01,
            'max' => 1000000000.00,
            'aliquota' => 0.43,
        ],
    ];
    private $irpef;

    public function __construct($imponibile = 0)
    {
        $this->imponibile = $imponibile;
        $this->irpef = 0.0;
    }

    public function GetRegistroFormattato()
    {
        return "€ " . number_format($this->imponibile, 2, ',', ' ');
    }

    public function GetIrpef()
    {
        $this->CalcolaIrpef();
        return $this->irpef;
    }

    public function GetIrpefFormattata()
    {
        return "€ " . number_format($this->GetIrpef(), 2, ',', ' ');
    }

    public function SetRegistro(float $valore)
    {
        $this->imponibile = $valore;
    }

    public function Fattura(float $totalefattura)
    {
        $this->imponibile += $totalefattura;
    }

    public function Spesa(float $costo)
    {
        $this->imponibile -= $costo;
    }

    public function CalcolaIrpef()
    {
        $irpef = 0;
        $imponibile_restante = $this->imponibile;
        // Suddivisione in tranche

        for ($c = 0; $c < count($this->aliquote); $c++) {
            // Se è maggiore del massimo prendi tutta la fetta
            if($imponibile_restante > $this->aliquote[$c]['max']) {
                $irpef += $this->aliquote[$c]['pagamentomax'];
            } else {
                if(($imponibile_restante >= $this->aliquote[$c]['min']) && ($imponibile_restante <= $this->aliquote[$c]['max'])) {
                    $imponibile_restante = $imponibile_restante - $this->aliquote[$c]['max'];
                    $irpef += ($imponibile_restante - $this->aliquote[$c]['min'])*$this->aliquote[$c]['aliquota'];
                    break;
                }                
            }
        }

        $this->irpef = $irpef;
    }
}

/*
fino a 15.000 euro 	            23%
da 15.001 fino a 28.000 euro    27%
                                3.450,00 + 27% sulla parte oltre i 15.000,00 euro
da 28.001 fino a 55.000 euro 	38%
                                6.960,00 + 38% sulla parte oltre i 28.000,00 euro
da 55.001 fino a 75.000 euro    41%
                                17.220,00 + 41% sulla parte oltre i 55.000,00 euro
oltre 75.000 euro               43%
                                25.420,00 + 43% sulla parte oltre i 75.000,00 euro
*/