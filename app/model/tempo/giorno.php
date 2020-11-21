<?php

namespace App\Model\Tempo;

use \App\Model\Tempo\Istanti;

class Giorno {

    public $data;
    public $giorno_settimana;
    public $giorno_settimana_breve;
    public $istanti;

    public function __construct(\DateTime $data, Istanti $istanti) {
        $this->data = $data;
        $this->giorno_settimana = $this->calcola_giorno_settimana($data);
        $this->giorno_settimana_breve = $this->calcola_giorno_settimana_breve($data);
        $this->istanti = $istanti;
    }

    public function GetGiorno() {
        $data = $this->data->format('d-m-Y');
        return $this->giorno_settimana_breve. " ". $data; 
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

    private function calcola_giorno_settimana_breve(\DateTime $data) {
        $giorno_settimana_numero = $data->format('N');
        switch ($giorno_settimana_numero) {
            case 1:$giorno_settimana = 'Lun';
                break;
            case 2:$giorno_settimana = 'Mar';
                break;
            case 3:$giorno_settimana = 'Mer';
                break;
            case 4:$giorno_settimana = 'Gio';
                break;
            case 5:$giorno_settimana = 'Ven';
                break;
            case 6:$giorno_settimana = 'Sab';
                break;
            case 7:$giorno_settimana = 'Dom';
                break;
            default:$giorno_settimana = '-';
        }
        return $giorno_settimana;
    }
}