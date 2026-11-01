<?php
session_start();
require_once __DIR__ . "/inc/protegeix.php";
require_once __DIR__ . "/inc/funcions.php";
$dades = require __DIR__ . "/inc/dades.php";


$usuari = $_SESSION["usuari_nom"];
$email = $_SESSION["usuari_email"];
$rol = $_SESSION["usuari_rol"];
$consulta = $dades["consulta"];
$opcions = $consulta["opcions"];


if ($rol !== "votant") {
    afegeixMissatge("Només els votants poden votar.");
    header("Location: benvinguda.php");
    exit;
}
if (!votacioOberta($consulta["tancament"])) {
    afegeixMissatge("La votació està tancada.");
    header("Location: resultats.php");
    exit;
}
if (jaHaVotat($email)) {
    afegeixMissatge("Ja has votat. Gràcies!");
    header("Location: resultats.php");
    exit;
}

$error = null;
if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $opcio = $_POST["opcio"] ?? null;
    if (is_string($opcio) && array_key_exists($opcio, $opcions)) {
        guardaVot($email, $opcio);
        afegeixMissatge("Vot registrat. Gràcies per participar!");
        header("Location: resultats.php");
        exit;
    }
    $error = "Tria una de les opcions.";
}

require_once __DIR__ . "/inc/capcalera.php";
?>
<h1><?= $consulta["pregunta"] ?></h1>

<?php if ($error !== null): ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="post" action="votacio.php">
    <?php foreach ($opcions as $clau => $text): ?>
        <label>
            <input type="radio" name="opcio" value="<?= $clau ?>">
            <?= $text ?>
        </label>
    <?php endforeach; ?>
    <button type="submit">Votar</button>
</form>
<?php require_once __DIR__ . "/inc/peu.php"; ?>