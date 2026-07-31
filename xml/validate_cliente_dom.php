<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

$percorso_xml = __DIR__ . "/cliente.xml";
$percorso_xsd = __DIR__ . "/cliente.xsd";

if (!file_exists($percorso_xml)) {
    die(
        "Manca cliente.xml. " .
        "Prima esegui export_cliente_dom.php."
    );
}

if (!file_exists($percorso_xsd)) {
    die("Manca cliente.xsd.");
}

libxml_use_internal_errors(true);

$dom = new DOMDocument();

if (!$dom->load($percorso_xml)) {

    echo "<h2>Errore durante la lettura di cliente.xml</h2>";

    foreach (libxml_get_errors() as $errore) {
        echo htmlspecialchars(
            $errore->message,
            ENT_QUOTES | ENT_SUBSTITUTE,
            "UTF-8"
        ) . "<br>";
    }

    libxml_clear_errors();
    exit();
}

if ($dom->schemaValidate($percorso_xsd)) {

    echo "<h2>XML valido rispetto allo schema XSD.</h2>";

} else {

    echo "<h2>XML non valido rispetto allo schema XSD.</h2>";

    foreach (libxml_get_errors() as $errore) {

        echo htmlspecialchars(
            $errore->message,
            ENT_QUOTES | ENT_SUBSTITUTE,
            "UTF-8"
        ) . "<br>";

    }

    libxml_clear_errors();
}