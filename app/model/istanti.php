<?php

namespace App\Model;

class Istanti {

    public $lista;
    
    public function __construct() {
        $this->lista = [];
    }

    public function GetLista() {
        return $this->lista;
    }

    public function AddIstante(\App\Model\Istante $i) {
        $this->lista[] = $i;
    }

    public function LoadIstanti(array $istanti) {
        $this->lista = $istanti;
    }

    // --------------------------------
    //        METODI STATICI
    // --------------------------------

    public static $SuddivisioneOraria = 1;

    public static function MakeIstanti($inizio, $fine, $suddivisione) {
        $istanti = [];

        if($suddivisione == self::$SuddivisioneOraria) {
            for($c = $inizio; $c < $fine; $c++) {
                $in = str_pad($c, 2, "0", STR_PAD_LEFT).":00";
                $out = str_pad($c+1, 2, "0", STR_PAD_LEFT).":00";
                $istanti[] = new \App\Model\Istante($in, $out);               
            }
        }

        return $istanti;
    }
}