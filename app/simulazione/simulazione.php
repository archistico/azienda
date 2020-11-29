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
use App\Model\Risposta\Azione;
use App\Model\Tasse\Irpef;
use App\Utilita\Utilita;

class Simulazione {

    public $giorni;
    public $azienda;
    public $fornitore;
    public $acquirente;
    public $mela;

    public function __construct() {
        // Dati impostazione simulazione
        $istanti_inizio = 4;
        $istanti_fine = 20;
        $istanti_suddivisione = Istanti::$SuddivisioneOraria;

        // Inizio simulazione compreso, fine simulazione escluso
        $giorni_inizio = \DateTime::createFromFormat('d-m-Y H:i:s', '01-01-2020 00:00:00');
        $giorni_fine = \DateTime::createFromFormat('d-m-Y H:i:s', '31-05-2020 00:00:00');

        
        // Creazione istanti
        $istanti = new Istanti();
        $istanti->LoadIstanti(Istanti::MakeIstanti($istanti_inizio, $istanti_fine, $istanti_suddivisione));

        // Creazione giorni
        $this->giorni = new Giorni();
        $this->giorni->LoadGiorni(Giorni::MakeGiorni($giorni_inizio, $giorni_fine, $istanti));

        // Mercato
        $this->mela = new Prodotto("Mela", 1, 2);
        $this->fornitore = new Fornitore($this->mela);
        $this->acquirente = new Acquirente();

        $cassa_iniziale = 10000;
        
        $this->azienda = new Azienda(new Cassa($cassa_iniziale), new Magazzino());
        
        $t = new Irpef(10000);
        $irpef = $t->GetIrpef();
        Utilita::Dump($irpef);
    }

    public function Run() {
        
        $logger = new Logger();

        foreach($this->giorni->lista as $giorno) {
            foreach($giorno->istanti->lista as $istante) {

                $log = new Log();
                $log->Aggiungi($giorno->giorno_settimana_breve . " " .$giorno->GetGiorno(). " ". $istante->GetIstante());

                $azione_azienda = $this->azienda->Azione($giorno, $istante);
                if($azione_azienda == Azione::$COMPRARE) {
                    $op = false;
                    $op = $this->azienda->Compra($this->fornitore, $this->mela, 100);
                    $op?$log->Aggiungi("comprato le mele"):$log->Aggiungi("non comprato le mele");
                } else {
                    $log->Aggiungi("-");
                }

                if($azione_azienda == Azione::$PAGARE_IVA) {
                    $op = false;
                    $op = $this->azienda->PagaIva();
                    $op?$log->Aggiungi("pagato iva"):$log->Aggiungi("non pagato iva");
                } else {
                    $log->Aggiungi("-");
                }

                $azione_acquirente = $this->acquirente->Azione($giorno, $istante);
                if($azione_acquirente == Azione::$COMPRARE) {
                    $op = false;
                    $op = $this->azienda->Vendi($this->acquirente, $this->mela, 10);
                    $op?$log->Aggiungi("venduto le mele"):$log->Aggiungi("non ho venduto le mele");
                } else {
                    $log->Aggiungi("-");
                }
                
                $log->Aggiungi("Cassa: ".$this->azienda->cassa->GetCassaFormattato());
                $log->Aggiungi("Magazzino: ".$this->azienda->magazzino->GetQuantiProdotti($this->mela)." mele");
                $log->Aggiungi("IVA: ".$this->azienda->iva->GetRegistroFormattato());
                $log->Aggiungi("Imponibile IRPEF: ".$this->azienda->irpef->GetRegistroFormattato());

                $logger->Aggiungi($log);
            }
        }

        return $logger;
        //Utilita::Dump($this->azienda->GetStato());
    }
}