<?php

// É realizada a verificação se existe devido a ela já existir em certas bibliotecas
if (!function_exists('dd')) {
    function dd($dump) {
        var_dump($dump);
        die();
    }
}
