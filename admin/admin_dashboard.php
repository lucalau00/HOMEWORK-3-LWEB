<?php

require_once __DIR__ . "/admin_auth.php";

?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">
    <title>Dashboard amministratore</title>
    <link rel="stylesheet" href="../css/style5.css">

</head>

<body>

    <h1>Dashboard amministratore</h1>

    <p>
        Benvenuto nell’area riservata dell’amministratore.
    </p>

    <div class="box">

        <h2>Gestione del sito</h2>

        <a href="admin_clienti.php">
            Visualizza clienti registrati
        </a>

        <br>

        <a href="admin_prenotazioni.php">
            Visualizza prenotazioni
        </a>

        <br>

        <a href="admin_pagamenti.php">
            Visualizza pagamenti
        </a>

    </div>

    <div class="box">

        <h2>Strumenti XML e XSD</h2>

        <a href="../xml/export_cliente_dom.php">
            Rigenera XML clienti
        </a>

        <br>

        <a href="../xml/validate_cliente_dom.php">
            Valida XML clienti tramite XSD
        </a>

        <br>

        <a href="../xml/mostra_cliente_dom.php">
            Visualizza XML clienti
        </a>

    </div>

    <p class="logout">

        <a href="logout.php">
            Logout
        </a>

    </p>

</body>

</html>