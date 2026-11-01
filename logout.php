<?php
session_start();
require_once __DIR__ . '/inc/funcions.php';

$nom = (string)($_SESSION["usuari_nom"] ?? "");

$p = session_get_cookie_params();
setcookie(session_name(), "", [
    "expires"  => time() - 42000,
    "path"     => $p["path"],
    "domain"   => $p["domain"],
    "secure"   => $p["secure"],
    "httponly" => $p["httponly"],
    "samesite" => $p["samesite"] !== "" ? $p["samesite"] : "Lax",
]);

$_SESSION = [];
session_destroy();

require_once __DIR__ . "/inc/capcalera.php";
?>
<h1>Fins la propera<?= $nom !== "" ? ", " . $nom : "" ?>!</h1>
<p><a href="index.php">Tornar a entrar</a></p>
<?php require_once __DIR__ . "/inc/peu.php"; ?>