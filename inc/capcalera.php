<?php
$usuari = $_SESSION['usuari_nom'] ?? null;
$rol = $_SESSION["usuari_rol"] ?? null;
$missatgeFlash = llegeixMissatge();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { 
            font-family: arial; 
            max-width: 750px; 
            margin: 20px auto;
            padding: 0 10px;
        }
        nav { 
            display: flex; 
            gap: 10px; 
            flex-wrap: wrap; 
            margin-bottom: 10px; 
        }
        .flash { 
            color: #00b7ff; 
        }
        .error { 
            color: #ff0000; 
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
        }
        th, td { 
            border: 1px solid #000; 
            text-align: left; 
        }
        label { 
            display: block; 
            margin: .4rem 0; 
        }
    </style>
</head>
<body>
<?php if (is_string($usuari)): ?>
    <nav>
        <strong><?= (string) ($usuari ?? '') ?></strong>
        <a href="benvinguda.php">Inici</a>
        <?php if (($rol ?? '') === 'votant'): ?>
            <a href="votacio.php">Votar</a>
        <?php endif; ?>
        <a href="resultats.php">Resultats</a>
        <a href="logout.php">Tancar sessió</a>
    </nav>
<?php endif; ?>
<?php if ($missatgeFlash !== null): ?>
    <div class="flash"><?= $missatgeFlash ?></div>
<?php endif; ?>
