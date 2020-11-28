<?php

namespace App\Model\Mercato;

use App\Model\Mercato\Fornitore;
use App\Model\Mercato\Acquirente;
use App\Model\Cassa\Cassa;
use App\Model\Magazzino\Magazzino;
use App\Model\Prodotto\Prodotto;
use App\Model\Tempo\Istante;
use App\Model\Tempo\Giorno;
use App\Model\Risposta\Azione;
use App\Model\Tasse\Iva;

class Azienda {

    public $cassa;
    public $magazzino;
    public $iva;

    public function __construct(Cassa $cassa, Magazzino $magazzino) {
        $this->cassa = $cassa;
        $this->magazzino = $magazzino;
        $this->iva = new Iva();
    }

    public function Compra(Fornitore $fornitore, Prodotto $prodotto, int $quantita) {
        $costo = $quantita * $prodotto->GetCosto();
        if(($fornitore->Vendi($prodotto, $quantita)) && ($this->cassa->ControllaQuantitaInCassa($costo))) {
            $this->cassa->Preleva($costo);
            for ($i = 0; $i < $quantita; $i++) {
                $this->magazzino->Aggiungi($prodotto);
            }
            $this->iva->CreditoAcquisto($costo);
            return true;
        } else {
            return false;
        }
    }

    public function Vendi(Acquirente $acquirente, Prodotto $prodotto, int $quantita) {
        $prezzo = $quantita * $prodotto->GetPrezzo();
        if(($acquirente->ControllaQuantitaInCassa($prezzo)) && ($this->magazzino->GetQuantiProdotti($prodotto) >= $quantita)) {
            $this->cassa->Deposita($quantita * $prodotto->GetPrezzo());
            for ($i = 0; $i < $quantita; $i++) {
                $this->magazzino->Rimuovi($prodotto);
            }
            $this->iva->DebitoVendita($prezzo);
            return true;
        } else {
            return false;
        }
    }

    public function GetStato() {
        return [
            'cassa' => $this->cassa->GetCassaFormattato(),
            'magazzino' => $this->magazzino->GetValoreMagazzinoFormattato(),
            'iva' => $this->iva->GetRegistroFormattato(),
        ];
    }

    public function PagaIva() {
        if($this->iva->GetIva()>=0) {
            $this->cassa->Preleva($this->iva->GetIva());
            $this->iva->SetRegistro(0);
            return true;
        } else {
            return false;
        }
        
    }

    public function Azione(Giorno $giorno, Istante $istante) {

        $numero_giorno_mese = $giorno->GetGiorno('d');
        $giorno_settimana_breve = $giorno->giorno_settimana_breve;

        if($giorno_settimana_breve == "Mer" && $istante->inizio == "04:00") {
            return Azione::$COMPRARE;
        }

        //&& $numero_giorno_mese == "01"
        if($istante->inizio == "10:00" ) {
            return Azione::$PAGARE_IVA;
        }

        return Azione::$NON_FARE_NULLA;
    }
}