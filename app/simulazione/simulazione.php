<?php

namespace App\Simulazione;

use App\Model\Tempo\Istanti;
use App\Model\Tempo\Giorni;
use App\Model\Cassa\Cassa;
use App\Model\Magazzino\Magazzino;
use App\Model\Prodotto\Prodotto;
use App\Model\Mercato\Fornitore;
use App\Model\Mercato\Acquirente;
use App\Model\Mercato\Azienda;
use App\Model\Log\Logger;
use App\Model\Log\Log;
use App\Utilita\Utilita;

class Simulazione {

    public $giorni;
    public $azienda;
    public $fornitore;
    public $acquirente;
    public $prodotto;

    public function __construct() {
        // Dati impostazione simulazione
        $istanti_inizio = 4;
        $istanti_fine = 20;
        $istanti_suddivisione = Istanti::$SuddivisioneOraria;

        // Inizio simulazione compreso, fine simulazione escluso
        $giorni_inizio = \DateTime::createFromFormat('d-m-Y H:i:s', '01-01-2020 00:00:00');
        $giorni_fine = \DateTime::createFromFormat('d-m-Y H:i:s', '08-01-2020 00:00:00');

        
        // Creazione istanti
        $istanti = new Istanti();
        $istanti->LoadIstanti(Istanti::MakeIstanti($istanti_inizio, $istanti_fine, $istanti_suddivisione));

        // Creazione giorni
        $this->giorni = new Giorni();
        $this->giorni->LoadGiorni(Giorni::MakeGiorni($giorni_inizio, $giorni_fine, $istanti));

        // Mercato
        $mela = new Prodotto("Mela", 0.2, 0.5);
        $this->fornitore = new Fornitore($mela);
        $this->acquirente = new Acquirente();

        $cassa_iniziale = 10000;
        
        $this->azienda = new Azienda(new Cassa($cassa_iniziale), new Magazzino());
        

    }

    public function Run() {
        $mela = new Prodotto("Mela", 0.2, 0.5);
        $logger = new Logger();

        foreach($this->giorni->lista as $giorno) {
            $data = $giorno->GetGiorno();
            $giorno_settimana_breve = $giorno->giorno_settimana_breve;

            foreach($giorno->istanti->lista as $istante) {

                $log = new Log();
                $log->Aggiungi($data. " ". $istante->GetIstante());
                
                if($giorno_settimana_breve == "Lun" && $istante->inizio == "04:00") {
                    $this->azienda->Compra($this->fornitore, $mela, 10);
                }

                if(in_array($giorno_settimana_breve, ["Lun", "Mar", "Mer", "Gio", "Ven"]) && $istante->inizio == "09:00") {
                    $this->azienda->Vendi($this->acquirente, $mela, 3);
                }

                $logger->Aggiungi($log);
            }
        }

        return $logger;
        //Utilita::Dump($this->azienda->GetStato());
    }
}