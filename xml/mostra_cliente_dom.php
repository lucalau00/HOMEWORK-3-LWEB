<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

$percorso_xml = __DIR__ . "/cliente.xml";

if (!file_exists($percorso_xml)) {
    die(
        "Manca il file cliente.xml. " .
        "Prima apri export_cliente_dom.php per generarlo."
    );
}

libxml_use_internal_errors(true);

$dom = new DOMDocument();

if (!$dom->load($percorso_xml)) {

    echo "<h2>Errore durante la lettura di cliente.xml</h2>";

    foreach (libxml_get_errors() as $errore) {
        echo htmlspecialchars($errore->message) . "<br>";
    }

    libxml_clear_errors();
    exit();
}

$clienti = $dom->getElementsByTagName("cliente");

/**
 * Restituisce il contenuto di un elemento figlio.
 */
function leggiElemento(DOMElement $elemento, string $nome): string
{
    $nodi = $elemento->getElementsByTagName($nome);

    if ($nodi->length === 0) {
        return "";
    }

    return trim($nodi->item(0)->textContent);
}

/**
 * Protegge il testo prima di mostrarlo nella pagina HTML.
 */
function escapeHtml(string $valore): string
{
    return htmlspecialchars(
        $valore,
        ENT_QUOTES | ENT_SUBSTITUTE,
        "UTF-8"
    );
}
?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">

    <title>Clienti da XML con DOM</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: rgb(250, 247, 235);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1000px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #cccccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .collegamenti {
            margin-bottom: 20px;
        }

        .collegamenti a {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .messaggio {
            margin-top: 20px;
            padding: 12px;
            background-color: #f2f2f2;
        }

    </style>

</head>

<body>

    <h1>Elenco clienti letti da XML con DOM</h1>

    <div class="collegamenti">

        <a href="export_cliente_dom.php">
            Rigenera XML dal database
        </a>

        <a href="validate_cliente_dom.php">
            Valida XML con XSD
        </a>

    </div>

    <?php if ($clienti->length === 0): ?>

        <div class="messaggio">
            Nel file cliente.xml non sono presenti clienti.
        </div>

    <?php else: ?>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Codice fiscale</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Data di nascita</th>
                    <th>Telefono</th>
                    <th>Email</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($clienti as $cliente): ?>

                    <?php
                    if (!($cliente instanceof DOMElement)) {
                        continue;
                    }
                    ?>

                    <tr>

                        <td>
                            <?= escapeHtml($cliente->getAttribute("id_cliente")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "cf")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "nome")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "cognome")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "data_nascita")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "telefono")) ?>
                        </td>

                        <td>
                            <?= escapeHtml(leggiElemento($cliente, "email")) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</body>

</html>