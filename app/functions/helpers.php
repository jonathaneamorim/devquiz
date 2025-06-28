<?php

// É realizada a verificação se existe devido a ela já existir em certas bibliotecas
if (!function_exists('dd')) {
    function dd($dump) {
        var_dump($dump);
        die();
    }
}

function startSessionIfNotStarted() {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function setFlash($key, $message) {
    startSessionIfNotStarted();
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    startSessionIfNotStarted();
    if(isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
