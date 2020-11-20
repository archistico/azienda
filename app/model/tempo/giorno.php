<?php

namespace App\Model\Tempo;

use \App\Model\Tempo\Istanti;

class Giorno {

    public $data;
    public $giorno_settimana;
    public $istanti;

    public function __construct(\DateTime $data, Istanti $istanti) {
        $this->data = $data;
        $this->giorno_settimana = $this->calcola_giorno_settimana($data);
        $this->istanti = $istanti;
    }

    private function calcola_giorno_settimana(\DateTime $data) {
        $giorno_settimana_numero = $data->format('N');
        switch ($giorno_settimana_numero) {
            case 1:$giorno_settimana = 'Lunedì';
                break;
            case 2:$giorno_settimana = 'Martedì';
                break;
            case 3:$giorno_settimana = 'Mercoledì';
                break;
            case 4:$giorno_settimana = 'Giovedì';
                break;
            case 5:$giorno_settimana = 'Venerdì';
                break;
            case 6:$giorno_settimana = 'Sabato';
                break;
            case 7:$giorno_settimana = 'Domenica';
                break;
            default:$giorno_settimana = '-';
        }
        return $giorno_settimana;
    }
}