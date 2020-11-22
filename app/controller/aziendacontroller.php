<?php

namespace App\Controller;

use App\Simulazione\Simulazione;
use App\Utilita\Utilita;

class AziendaController {
    public function Homepage($f3) {
        
        $simulazione = new Simulazione();
        $loggers = $simulazione->Run();

        //Utilita::DumpDie($loggers);
        
        $f3->set('loggers', $loggers->ToArray());

        $f3->set('titolo', 'Simulazione');
        $f3->set('contenuto', 'tabelle/istanti.htm');
        echo \Template::instance()->render('app/view/base.htm');
    }
}