<?php

require_once __DIR__ . "/admin_auth.php";
require_once __DIR__ . "/../connection.php";

$sql = "
    SELECT
        p.id_prenotazione,
        p.destinazione,
        p.categoria,
        p.costo,
        p.stato,
        c.nome,
        c.cognome,
        c.email
    FROM `$tabella_prenotazione` AS p
    INNER JOIN `$tabella_cliente` AS c
        ON p.id_cliente = c.id_cliente
    ORDER BY p.id_prenotazione ASC
";

$result = $conn->query($sql);

if (!$result) {
    die(
        "Errore durante il recupero delle prenotazioni: "
        . $conn->error
    );
}

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

    <title>Prenotazioni</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: rgb(250, 247, 235);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #cccccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            display: inline-block;
            margin-top: 15px;
        }

        .stato {
            font-weight: bold;
        }

    </style>

</head>

<body>

    <h1>Tutte le prenotazioni</h1>

    <table>

        <thead>

            <tr>
                <th>ID prenotazione</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Destinazione</th>
                <th>Categoria</th>
                <th>Costo</th>
                <th>Stato</th>
            </tr>

        </thead>

        <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= (int) $row["id_prenotazione"] ?>
                        </td>

                        <td>
                            <?= escapeHtml(
                                $row["nome"] . " " . $row["cognome"]
                            ) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["email"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["destinazione"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["categoria"]) ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $row["costo"],
                                2,
                                ",",
                                "."
                            ) ?> €
                        </td>

                        <td class="stato">
                            <?= escapeHtml($row["stato"]) ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7">
                        Nessuna prenotazione presente.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

    <br/>
    <button onclick="window.location.href='admin_dashboard.php'">
    Torna alla dashboard
    </button> 

</body>

</html>

<?php
$conn->close();
?>