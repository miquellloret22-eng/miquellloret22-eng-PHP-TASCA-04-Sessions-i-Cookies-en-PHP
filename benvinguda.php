<?php
session_start();

require_once __DIR__ . "/inc/protegeix.php";
require_once __DIR__ . "/inc/funcions.php";
$dades = require __DIR__ . "/inc/dades.php";

$usuari = $_SESSION["usuari_nom"];
$email = $_SESSION["usuari_email"];
$rol = $_SESSION["usuari_rol"];
$consulta = $dades["consulta"];
$oberta = votacioOberta($consulta["tancament"]);
$haVotat = jaHaVotat($email);
$horaLogin = (int) ($_SESSION["hora_login"] ?? time());
$primeraVegada = !isset($_SESSION["benvingut"]);

if ($primeraVegada) {
    $_SESSION["benvingut"] = true;
}

$tancament = date("d/m/Y", strtotime($consulta["tancament"])) . " a les " . date("H:i", strtotime($consulta["tancament"]));

require_once __DIR__ . "/inc/capcalera.php";
?>
<h1>Hola, <?= $usuari ?>!</h1>
<?php if ($primeraVegada): ?>
    <p>Benvingut! És la teva primera visita</p>
<?php else: ?>
    <p>Vas iniciar sessió <?= tempsDesDe($horaLogin) ?>.</p>
<?php endif; ?>


<h2><?= $consulta["pregunta"] ?></h2>
<?php if ($oberta): ?>
    <p>La votació és oberta fins al <?= $tancament ?>.</p>
<?php else: ?>
    <p>La votació està tancada (va tancar el <?= $tancament ?>).</p>
<?php endif; ?>

<?php if ($rol === "votant"): ?>
    <?php if ($haVotat): ?>
        <p>Ja has votat. <a href="resultats.php">Veure els resultats</a></p>
    <?php elseif ($oberta): ?>
        <p><a href="votacio.php">Votar ara</a></p>
    <?php endif; ?>
<?php elseif ($rol === "admin"): ?>
    <p><a href="resultats.php">Veure els resultats</a></p>
<?php endif;

require_once __DIR__ . "/inc/peu.php";
?>