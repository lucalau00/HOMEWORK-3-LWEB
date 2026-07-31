<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

require_once __DIR__ . "/../connection.php";

// Recupera tutti i clienti dal database
$sql = "
    SELECT
        id_cliente,
        CF,
        nome,
        cognome,
        data_nascita,
        telefono,
        email
    FROM $tabella_cliente
    ORDER BY id_cliente
";

$risultato = $conn->query($sql);

if (!$risultato) {
    die("Errore durante la lettura dei clienti: " . $conn->error);
}

$dom = new DOMDocument("1.0", "UTF-8");
$dom->formatOutput = true;

$root = $dom->createElement("clienti");
$dom->appendChild($root);

while ($riga = $risultato->fetch_assoc()) {

    $cliente = $dom->createElement("cliente");

    $cliente->setAttribute(
        "id_cliente",
        (string) $riga["id_cliente"]
    );

    aggiungiElemento($dom, $cliente, "cf", $riga["CF"]);
    aggiungiElemento($dom, $cliente, "nome", $riga["nome"]);
    aggiungiElemento($dom, $cliente, "cognome", $riga["cognome"]);
    aggiungiElemento($dom, $cliente, "data_nascita", $riga["data_nascita"]);
    aggiungiElemento($dom, $cliente, "telefono", $riga["telefono"]);
    aggiungiElemento($dom, $cliente, "email", $riga["email"]);

    $root->appendChild($cliente);
}

$percorso_xml = __DIR__ . "/cliente.xml";

if ($dom->save($percorso_xml) === false) {
    die("Errore durante la creazione di cliente.xml");
}

echo "Cliente.xml creato correttamente dal database.";

function aggiungiElemento(
    DOMDocument $dom,
    DOMElement $genitore,
    string $nome,
    mixed $valore
): void {

    $elemento = $dom->createElement($nome);

    $testo = $dom->createTextNode(
        (string) ($valore ?? "")
    );

    $elemento->appendChild($testo);
    $genitore->appendChild($elemento);
}