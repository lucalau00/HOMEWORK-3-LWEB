<?php

session_start();

// Svuota tutte le variabili della sessione
$_SESSION = [];

// Elimina il cookie della sessione, se presente
if (ini_get("session.use_cookies")) {
    $parametri_cookie = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametri_cookie["path"],
        $parametri_cookie["domain"],
        $parametri_cookie["secure"],
        $parametri_cookie["httponly"]
    );
}

// Distrugge completamente la sessione
session_destroy();

// Reindirizza alla home pubblica
header("Location: Home.html");
exit();