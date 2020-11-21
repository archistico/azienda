<?php

namespace App\Controller;

use App\Model\Tempo\Istanti;
use App\Model\Tempo\Giorni;
use App\Model\Cassa\Cassa;
use App\Model\Magazzino\Magazzino;
use App\Model\Prodotto\Prodotto;
use App\Model\Mercato\Fornitore;
use App\Model\Mercato\Acquirente;
use App\Model\Mercato\Azienda;
use App\Utilita\Utilita;

class AziendaController {
    public function Homepage() {
        
        // Dati impostazione simulazione
        $istanti_inizio = 4;
        $istanti_fine = 20;
        $istanti_suddivisione = Istanti::$SuddivisioneOraria;

        $giorni_inizio = \DateTime::createFromFormat('d-m-Y H:i:s', '01-01-2020 00:00:00');
        $giorni_fine = \DateTime::createFromFormat('d-m-Y H:i:s', '05-01-2020 00:00:00');

        $cassa_iniziale = 100;
        
        // Creazione istanti
        $istanti = new Istanti();
        $istanti->LoadIstanti(Istanti::MakeIstanti($istanti_inizio, $istanti_fine, $istanti_suddivisione));

        // Creazione giorni
        $giorni = new Giorni();
        $giorni->LoadGiorni(Giorni::MakeGiorni($giorni_inizio, $giorni_fine, $istanti));
        
        $mela = new Prodotto("Mela", 0.2, 0.5);

        $fornitore = new Fornitore($mela);
        $acquirente = new Acquirente();

        $azienda = new Azienda(new Cassa($cassa_iniziale), new Magazzino());
        $azienda->Compra($fornitore, $mela, 10);
        $azienda->Vendi($acquirente, $mela, 3);

        Utilita::DumpDie($azienda);
        
    }
}