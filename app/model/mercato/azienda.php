<?php

namespace App\Model\Mercato;

use \App\Model\Mercato\Fornitore;
use \App\Model\Mercato\Acquirente;
use \App\Model\Cassa\Cassa;
use \App\Model\Magazzino\Magazzino;
use \App\Model\Prodotto\Prodotto;
use App\Model\Tempo\Istante;
use App\Model\Tempo\Giorno;
use App\Model\Risposta\Azione;

class Azienda {

    public $cassa;
    public $magazzino;

    public function __construct(Cassa $cassa, Magazzino $magazzino) {
        $this->cassa = $cassa;
        $this->magazzino = $magazzino;
    }

    public function Compra(Fornitore $fornitore, Prodotto $prodotto, int $quantita) {
        $costo = $quantita * $prodotto->GetCosto();
        if(($fornitore->Vendi($prodotto, $quantita)) && ($this->cassa->ControllaQuantitaInCassa($costo))) {
            $this->cassa->Preleva($costo);
            for ($i = 0; $i < $quantita; $i++) {
                $this->magazzino->Aggiungi($prodotto);
            }
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
            return true;
        } else {
            return false;
        }
    }

    public function GetStato() {
        return [
            'cassa' => $this->cassa->GetCassaFormattato(),
            'magazzino' => $this->magazzino->GetValoreMagazzinoFormattato(),
        ];
    }

    public function Azione(Giorno $giorno, Istante $istante) {

        $data = $giorno->GetGiorno();
        $giorno_settimana_breve = $giorno->giorno_settimana_breve;

        if($giorno_settimana_breve == "Lun" && $istante->inizio == "04:00") {
            return Azione::$COMPRARE;
        }

        if(in_array($giorno_settimana_breve, ["Lun", "Mar", "Mer", "Gio", "Ven"]) && $istante->inizio == "09:00") {
            return Azione::$VENDERE;
        }

        return Azione::$NON_FARE_NULLA;

    }
}