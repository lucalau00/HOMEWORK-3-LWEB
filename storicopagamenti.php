<?php

session_start();

// Visualizzazione errori durante lo sviluppo
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once __DIR__ . "/connection.php";

// Controllo accesso utente
if (
    !isset($_SESSION["loggedin"])
    || $_SESSION["loggedin"] !== true
    || !isset($_SESSION["id_cliente"])
) {
    header("Location: login.php");
    exit();
}

$id_cliente = (int) $_SESSION["id_cliente"];

// Query storico pagamenti
$sqlStorico = "
    SELECT
        id_pagamento,
        data AS data_pagamento,
        importo,
        esito
    FROM `$tabella_pagamento`
    WHERE id_cliente = ?
    ORDER BY data DESC, id_pagamento DESC
";

$stmtStorico = $conn->prepare($sqlStorico);

if (!$stmtStorico) {
    die(
        "Errore nella preparazione della query: "
        . $conn->error
    );
}

$stmtStorico->bind_param("i", $id_cliente);
$stmtStorico->execute();

$resultStorico = $stmtStorico->get_result();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Storico viaggi</title>
    <link rel="stylesheet" href="css/style4.css">
</head>

<body>

<div class="container">

    <h1>Storico dei tuoi pagamenti</h1>

    <table>

        <thead>
        <tr>
            <th>ID pagamento</th>
            <th>Data</th>
            <th>Importo</th>
            <th>Esito</th>
        </tr>
        </thead>

        <tbody>

        <?php if ($resultStorico->num_rows === 0): ?>

            <tr>
                <td colspan="4">
                    Non hai ancora effettuato nessun pagamento.
                </td>
            </tr>

        <?php else: ?>

            <?php while ($row = $resultStorico->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= (int) $row["id_pagamento"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $row["data_pagamento"]
                        ) ?>
                    </td>

                    <td>
                        <?= number_format(
                            (float) $row["importo"],
                            2,
                            ",",
                            "."
                        ) ?> €
                    </td>

                    <td>
                        <?= htmlspecialchars($row["esito"]) ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        <?php endif; ?>

        </tbody>

    </table>

    <div class="bottoni-fine">

        <a href="home2.php" class="btn">
            ⬅️ Torna alla home
        </a>

    </div>

</div>

</body>
</html>

<?php

$stmtStorico->close();
$conn->close();

?>