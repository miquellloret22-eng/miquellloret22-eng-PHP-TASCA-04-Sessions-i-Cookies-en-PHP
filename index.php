<?php
session_start();
require_once __DIR__ . "/inc/funcions.php";
$dades = require __DIR__ . '/inc/dades.php';

if (isset($_SESSION["usuari_autenticat"])) {
    header("Location: benvinguda.php");
    exit;
}

$errors = [
    "credencials" => "Credencials no vàlides.",
    "acces"       => "Primer has d'iniciar sessió.",
    "caducada"    => "La sessió ha caducat per inactivitat.",
];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $contrasenya = $_POST["contrasenya"] ?? "";
    $recordar = isset($_POST["recordar"]);

    if ($recordar && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie("recordar_email", $email, [
            'expires'  => time() + 30 * 86400,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            ]);
    } else {
        setcookie("recordar_email", "", [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            ]);
    }


    foreach ($dades["usuaris"] as $usuari) {
        if ($email === $usuari["email"] && $contrasenya === $usuari["contrasenya"]) {
            session_regenerate_id(true);
            $_SESSION["usuari_autenticat"] = true;
            $_SESSION["usuari_nom"] = $usuari["nom"];
            $_SESSION["usuari_email"] = $email;
            $_SESSION["usuari_rol"] = $usuari["rol"];
            $_SESSION["hora_login"] = time();

            header("Location: benvinguda.php");
            exit;
        }
    }
    header('Location: index.php?error=credencials');
    exit;
}

$clauError = $_GET['error'] ?? '';
$missatgeError = (is_string($clauError) && array_key_exists($clauError, $errors)) ? $errors[$clauError] : null;


$cookieVisita = $_COOKIE["darrera_visita"] ?? null;
$missatgeVisita = "Benvingut! És la teva primera visita.";
if (is_string($cookieVisita) && ctype_digit($cookieVisita)) {
    $moment = (int) $cookieVisita;
    if ($moment > 0 && $moment <= time()) {
        $missatgeVisita = "La teva darrera visita va ser " . tempsDesDe($moment);
    }
}
setcookie("darrera_visita", (string) time(), [
    'expires'  => time() + 30 * 86400,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    ]);

$recordarEmail = "";
$cookieEmail = $_COOKIE["recordar_email"] ?? null;
if (is_string($cookieEmail) && filter_var($cookieEmail, FILTER_VALIDATE_EMAIL)) {
    $recordarEmail = $cookieEmail;
}

require_once __DIR__ . "/inc/capcalera.php";
?>
    <h1>Login:</h1>
    <?php if ($missatgeError !== null): ?>
    <p class="error"><?= $missatgeError ?></p>
    <?php endif; ?>

    <form action = "" method = "post">
        Email: <input type = "text" name = "email" required value = "<?= htmlspecialchars($recordarEmail ?? '', ENT_QUOTES, 'UTF-8') ?>"><br>
        Contrasenya: <input type="password" name="contrasenya" required><br>
        Recordar el meu email <input type="checkbox" name="recordar" value="1"><br>
        <input type="submit" value="enviar">
    </form>
</body>
</html>