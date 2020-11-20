<?php

namespace App\Model;

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

    public function AddGiorno(\App\Model\Giorno $g)
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

    public static function MakeGiorni($inizio, $fine, $istanti)
    {
        $giorni = [];

        $intervallo = \DateInterval::createFromDateString('1 day');
        $periodo = new \DatePeriod($inizio, $intervallo, $fine);

        foreach ($periodo as $dt) {
            $giorni[] = new \App\Model\Giorno($dt, $istanti);
        }

        return $giorni;
    }
}
