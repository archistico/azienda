<?php

namespace App\Model\Tempo;

use \App\Model\Tempo\Istanti;
use \App\Model\Tempo\Giorno;

class Giorni
{

    public $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function GetLista()
    {
        return $this->lista;
    }

    public function AddGiorno(Giorno $g)
    {
        $this->lista[] = $g;
    }

    public function LoadGiorni(array $giorni)
    {
        $this->lista = $giorni;
    }

    // --------------------------------
    //        METODI STATICI
    // --------------------------------

    public static function MakeGiorni(\DateTime $inizio, \DateTime $fine, Istanti $istanti)
    {
        $giorni = [];

        $intervallo = \DateInterval::createFromDateString('1 day');
        $periodo = new \DatePeriod($inizio, $intervallo, $fine);

        foreach ($periodo as $dt) {
            $giorni[] = new Giorno($dt, $istanti);
        }

        return $giorni;
    }
}
