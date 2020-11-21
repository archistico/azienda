<?php

namespace App\Controller;

use App\Simulazione\Simulazione;
use App\Utilita\Utilita;

class AziendaController {
    public function Homepage() {
        
        $simulazione = new Simulazione();
        $simulazione->Run();       
    }
}