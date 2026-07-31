<?php

session_start();

require_once __DIR__ . "/connection.php";

if (
    !isset($_SESSION["loggedin"])
    || $_SESSION["loggedin"] !== true
    || !isset($_SESSION["id_cliente"])
) {
    header("Location: login.php");
    exit();
}

$id_cliente = (int) $_SESSION["id_cliente"];
$errore = "";

// Se l'utente clicca su "Aggiungi alla prenotazione"
if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["aggiungi_prenotazione"])
) {
    $destinazione = isset($_POST["destinazione"])
        ? trim($_POST["destinazione"])
        : "";

    $categoria = isset($_POST["categoria"])
        ? trim($_POST["categoria"])
        : "";

    $data_partenza = isset($_POST["data_partenza"])
        ? $_POST["data_partenza"]
        : "";

    $data_rientro = isset($_POST["data_rientro"])
        ? $_POST["data_rientro"]
        : "";

    $costo = isset($_POST["costo"])
        ? (float) $_POST["costo"]
        : 0;

    if (
        $destinazione === ""
        || $categoria === ""
        || $costo <= 0
    ) {
        $errore = "Dati della prenotazione non validi.";
    } else {

        // Controllo se la prenotazione esiste già
        $sql_check = "
            SELECT id_prenotazione
            FROM `$tabella_prenotazione`
            WHERE id_cliente = ?
            AND destinazione = ?
            AND categoria = ?
            AND costo = ?
        ";

        $stmtCheck = $conn->prepare($sql_check);

        if (!$stmtCheck) {
            die(
                "Errore nella preparazione del controllo: "
                . $conn->error
            );
        }

        $stmtCheck->bind_param(
            "issd",
            $id_cliente,
            $destinazione,
            $categoria,
            $costo
        );

        $stmtCheck->execute();
        $resCheck = $stmtCheck->get_result();

        if ($resCheck->num_rows === 0) {

            $sql_insert = "
                INSERT INTO `$tabella_prenotazione`
                (
                    id_cliente,
                    destinazione,
                    categoria,
                    costo
                )
                VALUES (?, ?, ?, ?)
            ";

            $stmtIns = $conn->prepare($sql_insert);

            if (!$stmtIns) {
                die(
                    "Errore nella preparazione dell'inserimento: "
                    . $conn->error
                );
            }

            $stmtIns->bind_param(
                "issd",
                $id_cliente,
                $destinazione,
                $categoria,
                $costo
            );

            if (!$stmtIns->execute()) {
                $errore =
                    "Errore durante l'inserimento della prenotazione: "
                    . $stmtIns->error;
            }

            $stmtIns->close();
        }

        $stmtCheck->close();

        if ($errore === "") {
            $conn->close();

            header("Location: prenotazione.php");
            exit();
        }
    }
}

// Lettura del file XML
$xml_path = __DIR__ . "/xml/reykjavik.xml";

$xml = simplexml_load_file($xml_path);

if ($xml === false) {
    die("Errore nel caricamento del file XML di Reykjavik.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Reykjavik - Viaggio</title>
    <link rel="stylesheet" href="css/style3.css">
</head>

<body>

<div class="container">

    <h1>Prenotazione viaggio Reykjavik</h1>

    <?php if ($errore !== ""): ?>

        <p style="color: red;">
            <?= htmlspecialchars($errore) ?>
        </p>

    <?php endif; ?>

    <table>

        <thead>
        <tr>
            <th>Destinazione</th>
            <th>Categoria</th>
            <th>Data partenza</th>
            <th>Data rientro</th>
            <th>Prezzo</th>
            <th>Azione</th>
        </tr>
        </thead>

        <tbody>

        <?php if (count($xml->pacchetto_reykjavik) > 0): ?>

            <?php foreach ($xml->pacchetto_reykjavik as $pacchetto): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars(
                            (string) $pacchetto->destinazione
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) $pacchetto->categoria
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) $pacchetto->data_partenza
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) $pacchetto->data_rientro
                        ) ?>
                    </td>

                    <td>
                        <?= number_format(
                            (float) $pacchetto->costo,
                            2,
                            ",",
                            "."
                        ) ?> €
                    </td>

                    <td>

                        <form method="post">

                            <input
                                type="hidden"
                                name="destinazione"
                                value="<?= htmlspecialchars(
                                    (string) $pacchetto->destinazione
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="categoria"
                                value="<?= htmlspecialchars(
                                    (string) $pacchetto->categoria
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="data_partenza"
                                value="<?= htmlspecialchars(
                                    (string) $pacchetto->data_partenza
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="data_rientro"
                                value="<?= htmlspecialchars(
                                    (string) $pacchetto->data_rientro
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="costo"
                                value="<?= htmlspecialchars(
                                    (string) $pacchetto->costo
                                ) ?>"
                            >

                            <button
                                type="submit"
                                name="aggiungi_prenotazione"
                                class="btn"
                            >
                                Aggiungi al carrello
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="6">
                    Nessun viaggio trovato.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

    <div class="contenitore-bottoni-fine">

        <a class="btn a" href="destinazioni2.php">
            ⬅️ Indietro
        </a>

    </div>

</div>

</body>
</html>