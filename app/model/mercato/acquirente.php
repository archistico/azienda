<?php

namespace App\Model\Mercato;

use App\Model\Tempo\Istante;
use App\Model\Tempo\Giorno;
use App\Model\Risposta\Azione;

class Acquirente {

    public function __construct() {
    }

    public function ControllaQuantitaInCassa(int $quantita) {
        return true;
    }

    public function Azione(Giorno $giorno, Istante $istante) {

        $data = $giorno->GetGiorno();
        $giorno_settimana_breve = $giorno->giorno_settimana_breve;

        if(in_array($giorno_settimana_breve, ["Lun", "Mar", "Mer", "Gio", "Ven"]) && ($istante->inizio == "09:00" || $istante->inizio == "14:00")) {
            return Azione::$COMPRARE;
        }

        return Azione::$NON_FARE_NULLA;

    }
    
}