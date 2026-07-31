<?php

session_start();

require_once __DIR__ . "/connection.php";

if (
    !isset($_SESSION["loggedin"])
    || $_SESSION["loggedin"] !== true
    || !isset($_SESSION["id_cliente"])
) {
    die("Errore: utente non loggato.");
}

$id_cliente = (int) $_SESSION["id_cliente"];

// Se arrivo dalla pagina pagaora.php,
// pulisco l'eventuale totale precedente
if (
    basename($_SERVER["HTTP_REFERER"] ?? "")
    === "pagaora.php"
) {
    unset($_SESSION["totale_pagamento"]);
}

// Rimozione prenotazione dal carrello
if (isset($_POST["rimuovi"])) {

    $id_prenotazione = isset($_POST["id_prenotazione"])
        ? (int) $_POST["id_prenotazione"]
        : 0;

    $delete = "
        DELETE FROM `$tabella_prenotazione`
        WHERE id_prenotazione = ?
          AND id_cliente = ?
    ";

    $stmtDel = $conn->prepare($delete);

    if (!$stmtDel) {
        die(
            "Errore nella preparazione della cancellazione: "
            . $conn->error
        );
    }

    $stmtDel->bind_param(
        "ii",
        $id_prenotazione,
        $id_cliente
    );

    $stmtDel->execute();
    $stmtDel->close();

    header("Location: prenotazione.php");
    exit;
}

// Recupero solo delle prenotazioni ancora nel carrello
$sql = "
    SELECT
        id_prenotazione,
        destinazione,
        categoria,
        costo
    FROM `$tabella_prenotazione`
    WHERE id_cliente = ?
      AND stato = 'nel_carrello'
    ORDER BY id_prenotazione ASC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(
        "Errore nella preparazione della query: "
        . $conn->error
    );
}

$stmt->bind_param("i", $id_cliente);
$stmt->execute();

$result = $stmt->get_result();

$prenotazioni = [];
$totale = 0;

while ($r = $result->fetch_assoc()) {
    $prenotazioni[] = $r;
    $totale += (float) $r["costo"];
}

// Memorizzo il totale per la pagina di pagamento
$_SESSION["totale_pagamento"] = $totale;

$stmt->close();
$conn->close();

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
    <title>Prenotazione</title>
    <link rel="stylesheet" href="css/style4.css">
</head>

<body>

<div class="container">

    <h1>Il tuo carrello</h1>

    <table>

        <thead>
        <tr>
            <th>Destinazione</th>
            <th>Categoria</th>
            <th>Costo</th>
            <th>Rimuovi</th>
        </tr>
        </thead>

        <tbody>

        <?php if (count($prenotazioni) === 0): ?>

            <tr>
                <td colspan="4">
                    Nessuna prenotazione presente.
                </td>
            </tr>

        <?php else: ?>

            <?php foreach ($prenotazioni as $prenotazione): ?>

                <tr>

                    <td>
                        <?= escapeHtml(
                            $prenotazione["destinazione"]
                        ) ?>
                    </td>

                    <td>
                        <?= escapeHtml(
                            $prenotazione["categoria"]
                        ) ?>
                    </td>

                    <td>
                        <?= number_format(
                            (float) $prenotazione["costo"],
                            2,
                            ",",
                            "."
                        ) ?> €
                    </td>

                    <td>

                        <form method="post">

                            <input
                                type="hidden"
                                name="id_prenotazione"
                                value="<?=
                                    (int) $prenotazione[
                                        "id_prenotazione"
                                    ]
                                ?>"
                            >

                            <button
                                type="submit"
                                name="rimuovi"
                                class="btn btn-danger"
                            >
                                Rimuovi
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>

    <div class="totale">
        Totale:
        <?= number_format(
            $totale,
            2,
            ",",
            "."
        ) ?> €
    </div>

    <div class="bottoni-fine">

        <a href="destinazioni2.php" class="btn">
            ⬅️ Torna ai viaggi
        </a>

        <?php if ($totale > 0): ?>

            <a href="pagaora.php" class="btn">
                💳 Procedi al pagamento
            </a>

        <?php endif; ?>

    </div>

</div>

</body>
</html>