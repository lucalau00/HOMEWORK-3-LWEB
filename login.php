<?php

session_start();

require_once __DIR__ . "/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST["email"])
        ? trim($_POST["email"])
        : "";

    $password = isset($_POST["password"])
        ? $_POST["password"]
        : "";

    // LOGIN ADMIN
    if ($email === "admin@gmail.com" && $password === "admin") {
        $_SESSION["loggedin"] = true;
        $_SESSION["is_admin"] = true;
        $_SESSION["email"] = "admin@gmail.com";

        header("Location: admin/admin_dashboard.php");
        exit();
    }

    // LOGIN CLIENTE
    $sql = "SELECT * FROM `$tabella_cliente` WHERE email = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if (
        $cliente
        && password_verify($password, $cliente["password"])
    ) {
        $_SESSION["email"] = $cliente["email"];
        $_SESSION["loggedin"] = true;
        $_SESSION["is_admin"] = false;
        $_SESSION["id_cliente"] = $cliente["id_cliente"];

        header("Location: home2.php");
        exit();
    }

    $login_error = "Credenziali non valide";

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style2.css">
</head>

<body style="background-color: rgb(250, 247, 235)">

<div class="container">

    <div class="left-panel">
        <img src="Immagini/login.jpg" alt="Immagine di viaggio">

        <h2>Vivi la tua prossima avventura!</h2>

        <p>Scopri il mondo con noi, un viaggio alla volta</p>
    </div>

    <div class="right-panel">

        <h1 class="logo">Scopri. Esplora. Vivi.</h1>

        <h2>Benvenuti a TravelUp!</h2>

        <?php if (isset($login_error)): ?>
            <p class="errore">
                <?= htmlspecialchars($login_error) ?>
            </p>
        <?php endif; ?>

        <form
            action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            method="post"
            class="login-form"
        >

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Inserisci email"
                required
            >

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Inserisci password"
                required
            >

            <br>

            <button type="submit" class="btn a">
                Accedi
            </button>

            <p class="signup">
                Non hai un account?
            </p>

            <a href="account.php" class="btn a">
                Crea account
            </a>

        </form>

    </div>

</div>

</body>
</html>