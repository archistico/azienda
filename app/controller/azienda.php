<?php

namespace App\Controller;

use \App\Model\Tempo\Istanti;
use \App\Model\Tempo\Istante;
use \App\Model\Tempo\Giorno;
use \App\Model\Tempo\Giorni;
use \App\Utilita\Utilita;

class Azienda {
    public function Homepage() {
        
        // Dati impostazione simulazione
        $istanti_inizio = 4;
        $istanti_fine = 20;
        $istanti_suddivisione = Istanti::$SuddivisioneOraria;

        $giorni_inizio = \DateTime::createFromFormat('d-m-Y H:i:s', '01-01-2020 00:00:00');
        $giorni_fine = \DateTime::createFromFormat('d-m-Y H:i:s', '05-01-2020 00:00:00');
        
        // Creazione istanti
        $istanti = new Istanti();
        $istanti->LoadIstanti(Istanti::MakeIstanti($istanti_inizio, $istanti_fine, $istanti_suddivisione));

        // Creazione giorni
        $giorni = new Giorni();
        $giorni->LoadGiorni(Giorni::MakeGiorni($giorni_inizio, $giorni_fine, $istanti));

        
        Utilita::DumpDie($giorni);

        // Utilita::DumpDie($istanti);
        
    }
}