<?php
session_start();
require_once __DIR__ . "/inc/funcions.php";
require_once __DIR__ . "/inc/protegeix.php";
$dades = require __DIR__ . "/inc/dades.php";

$usuari = $_SESSION["usuari_nom"];
$email = $_SESSION["usuari_email"];
$rol = $_SESSION["usuari_rol"];
$consulta = $dades["consulta"];
$oberta = votacioOberta($consulta["tancament"]);

$potVeure = $rol === "admin" || !$oberta || jaHaVotat($email);

if (!$potVeure) {
    afegeixMissatge("Podràs veure els resultats quan hagis votat.");
    header("Location: votacio.php");
    exit;
}

$vots = llegeixVots();
$compte = recompte($vots, $consulta["opcions"]);
$totalVots = array_sum($compte);
$totalVotants = 0;
$votat = 0;
foreach ($dades["usuaris"] as $usuari) {
    if (($usuari["rol"] ?? "") === "votant") {
        $totalVotants++;

        if (array_key_exists($usuari["email"], $vots)) {
            $votat++;
        }
    }
}


require_once __DIR__ . "/inc/capcalera.php";
?>
<h1>Resultats</h1>
<h2><?= $consulta["pregunta"] ?></h2>

<table>
    <tr>
        <th>Opció</th>
        <th>Vots</th>
        <th>Percentatge</th>
    </tr>
    <?php foreach ($consulta["opcions"] as $clau => $text):
        $n = $compte[$clau] ?? 0;
        $percentatge = $totalVots > 0 ? (int) round($n * 100 / $totalVots) : 0;
    ?>
    <tr>
        <td><?= $text ?></td>
        <td><?= $n ?></td>
        <td><?= $percentatge ?>%</td>
    </tr>
    <?php endforeach; ?>
</table>

<p>Participació: <?= $votat ?> de <?= $totalVotants ?> votants</p>
<?php require_once __DIR__ . "/inc/peu.php"; ?>