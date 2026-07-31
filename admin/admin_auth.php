<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (
    !isset($_SESSION["loggedin"]) ||
    $_SESSION["loggedin"] !== true
) {
    header("Location: ../login.php");
    exit;
}

if (
    !isset($_SESSION["is_admin"]) ||
    $_SESSION["is_admin"] !== true
) {
    header("Location: ../home2.php");
    exit;
}