<?php

session_start();

// Visualizzazione temporanea degli errori
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

require_once __DIR__ . "/connection.php";

// Controllo login cliente
if (
    !isset($_SESSION["loggedin"])
    || $_SESSION["loggedin"] !== true
    || !isset($_SESSION["id_cliente"])
    || (
        isset($_SESSION["is_admin"])
        && $_SESSION["is_admin"] === true
    )
) {
    die("Errore: utente non loggato.");
}

$id_cliente = (int) $_SESSION["id_cliente"];

// Recupero il totale dalla sessione
$totale = isset($_SESSION["totale_pagamento"])
    ? (float) $_SESSION["totale_pagamento"]
    : 0;

$esito = "non effettuato";
$pagamento_completato = false;

if ($totale > 0) {

    $esito = "approvato";

    $conn->begin_transaction();

    try {

        // Inserimento del pagamento
        $sql_pagamento = "
            INSERT INTO `$tabella_pagamento`
            (
                data,
                importo,
                esito,
                id_cliente
            )
            VALUES
            (
                CURDATE(),
                ?,
                ?,
                ?
            )
        ";

        $stmt_pagamento = $conn->prepare($sql_pagamento);

        if (!$stmt_pagamento) {
            throw new Exception(
                "Errore nella preparazione del pagamento: "
                . $conn->error
            );
        }

        $stmt_pagamento->bind_param(
            "dsi",
            $totale,
            $esito,
            $id_cliente
        );

        if (!$stmt_pagamento->execute()) {
            throw new Exception(
                "Errore durante il pagamento: "
                . $stmt_pagamento->error
            );
        }

        $stmt_pagamento->close();

        /*
         * Le prenotazioni non vengono più eliminate.
         * Vengono segnate come pagate, così restano visibili
         * nella pagina amministratore.
         */
        $sql_aggiorna_prenotazioni = "
            UPDATE `$tabella_prenotazione`
            SET stato = 'pagata'
            WHERE id_cliente = ?
              AND stato = 'nel_carrello'
        ";

        $stmt_aggiorna = $conn->prepare(
            $sql_aggiorna_prenotazioni
        );

        if (!$stmt_aggiorna) {
            throw new Exception(
                "Errore nella preparazione "
                . "dell'aggiornamento delle prenotazioni: "
                . $conn->error
            );
        }

        $stmt_aggiorna->bind_param(
            "i",
            $id_cliente
        );

        if (!$stmt_aggiorna->execute()) {
            throw new Exception(
                "Errore durante l'aggiornamento "
                . "delle prenotazioni: "
                . $stmt_aggiorna->error
            );
        }

        $stmt_aggiorna->close();

        // Conferma tutte le operazioni
        $conn->commit();

        $pagamento_completato = true;

        // Elimina il totale dalla sessione per evitare doppi pagamenti
        unset($_SESSION["totale_pagamento"]);

    } catch (Throwable $errore) {

        $conn->rollback();

        die(
            "Pagamento non completato: "
            . htmlspecialchars(
                $errore->getMessage(),
                ENT_QUOTES | ENT_SUBSTITUTE,
                "UTF-8"
            )
        );
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">

    <title>Pagamento completato</title>

    <link rel="stylesheet" href="css/style2.css">

</head>

<body>

    <div class="container">

        <div class="left-panel">

            <img
                src="Immagini/login.jpg"
                alt="Immagine di viaggio"
            >

            <h2>
                Vivi la tua prossima avventura!
            </h2>

            <p>
                Scopri il mondo con noi, un viaggio alla volta.
            </p>

        </div>

        <div class="right-panel">

            <h1 class="logo">
                Scopri. Esplora. Vivi.
            </h1>

            <h2>
                Benvenuti a TravelUp!
            </h2>

            <div style="text-align: center;">

                <?php if ($pagamento_completato): ?>

                    <h2>

                        <strong>
                            ✨ CONGRATULAZIONI! ✨
                        </strong>

                        <br>

                        IL PAGAMENTO È ANDATO A BUON FINE

                    </h2>

                    <p style="font-size: 18px;">

                        Importo pagato:

                        <strong>
                            <?= number_format(
                                $totale,
                                2,
                                ",",
                                "."
                            ) ?> €
                        </strong>

                    </p>

                    <p style="color: gray;">

                        Esito:

                        <?= htmlspecialchars(
                            $esito,
                            ENT_QUOTES | ENT_SUBSTITUTE,
                            "UTF-8"
                        ) ?>

                    </p>

                <?php else: ?>

                    <h2>
                        Nessun pagamento da effettuare
                    </h2>

                    <p>
                        Il carrello è vuoto oppure il pagamento
                        è già stato completato.
                    </p>

                <?php endif; ?>

                <div class="contenitore-bottoni-fine">

                    <button
                        type="button"
                        onclick="window.location.href='prenotazione.php'"
                        class="btn btn-sinistra"
                    >
                        ⬅️ Torna al carrello
                    </button>

                    <button
                        type="button"
                        onclick="window.location.href='home2.php'"
                        class="btn btn-sinistra"
                    >
                        🏠 Torna alla Homepage
                    </button>

                </div>

            </div>

        </div>

    </div>

</body>

</html>