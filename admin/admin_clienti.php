<?php

require_once __DIR__ . "/admin_auth.php";
require_once __DIR__ . "/../connection.php";

$sql = "
    SELECT
        id_cliente,
        CF,
        nome,
        cognome,
        email,
        telefono,
        data_nascita
    FROM `$tabella_cliente`
    ORDER BY id_cliente ASC
";

$result = $conn->query($sql);

if (!$result) {
    die(
        "Errore durante il recupero dei clienti: "
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

    <title>Clienti registrati</title>

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

    </style>

</head>

<body>

    <h1>Clienti registrati</h1>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Codice fiscale</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Data di nascita</th>
            </tr>

        </thead>

        <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= (int) $row["id_cliente"] ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["CF"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["nome"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["cognome"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["email"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["telefono"]) ?>
                        </td>

                        <td>
                            <?= escapeHtml($row["data_nascita"]) ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7">
                        Nessun cliente registrato.
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