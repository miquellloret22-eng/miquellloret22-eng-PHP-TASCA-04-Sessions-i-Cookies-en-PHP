<?php
if (!isset($_SESSION["usuari_autenticat"])) {
    header("Location: index.php?error=acces");
    exit;
};

$timeout = 300;

if (isset($_SESSION["ultima_activitat"])) {
    $temps_inactiu = time() - $_SESSION["ultima_activitat"];

    if ($temps_inactiu > $timeout) {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?error=caducada");
        exit;
    };
};

$_SESSION["ultima_activitat"] = time();