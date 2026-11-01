<?php
declare(strict_types=1);

require_once __DIR__ . '/vots.php';

function buscaUsuari(array $usuaris, string $email): ?array {
    foreach ($usuaris as $u) {
        if ($u["email"] == $email) {
            return $u;
        }
    }
    return null;
}

function tempsDesDe(int $moment): string {
    $diferencia = time() - $moment;
    if ($diferencia < 60) {
        return "fa menys d'un minut";
    }

    if ($diferencia < 3600) {
        $quantitat = intdiv($diferencia, 60);
        $unitat = $quantitat === 1 ? "minut" : "minuts";
    } elseif ($diferencia < 86400) {
        $quantitat = intdiv($diferencia, 3600);
        $unitat = $quantitat === 1 ? "hora" : "hores";
    } else {
        $quantitat = intdiv($diferencia, 86400);
        $unitat = $quantitat === 1 ? "dia" : "dies";
    }

    return "fa $quantitat $unitat";
}

function votacioOberta(string $tancament): bool {
    return strtotime($tancament) > time();
}

function jaHaVotat(string $email): bool {
    $vots = llegeixVots();
    return array_key_exists($email, $vots);
}

function recompte(array $vots, array $opcions): array {
    $total = [];
    foreach ($opcions as $clau => $o) {
        $total[$clau] = 0;
    }
    foreach ($vots as $email => $v) {
        if (is_string($v) && array_key_exists($v, $opcions)) {
            $total[$v]++;
        }
    }
    return $total;
}

function afegeixMissatge(string $text): void {
    $_SESSION["missatge_flash"] = $text;
}

function llegeixMissatge(): ?string {
    if (isset($_SESSION["missatge_flash"])) {
        $missatge = (string) $_SESSION["missatge_flash"];
        unset($_SESSION["missatge_flash"]);
        return $missatge;
    }
    return null;
}