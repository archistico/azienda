<?php

require 'vendor/autoload.php';


if(file_exists('./env.php')) {
    include './env.php';
}

if(!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

// ----------------------
//   FAT FREE FRAMEWORK
// ----------------------

$f3 = \Base::instance();
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);

// ----------------------
//         ROUTE
// ----------------------
$f3->route('GET @home: /', '\App\Controller\Azienda->Homepage');

$f3->run();
