<?php
require_once("autoload.php");

$lighting = new Lighting();
$zoneFilter = $_GET['zone'] ?? 'all';
$lamps = $lighting->getAllLamps($zoneFilter);
$zones = $lighting->getZones();
$powerPerZone = $lighting->getPowerByZone();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Control de Lámparas</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #aaa; padding: 10px; text-align: center; }
        .on { color: green; font-weight: bold; }
        .off { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h1>Control de Lámparas del Estadio</h1>

<form method="get" action="index.php">
    <label for="zone">Filtrar por zona:</label>
    <select name="zone" id="zone" onchange="this.form.submit()">
        <option value="all">Todas</option>
        <?php $lighting->drawZonesOptions($zoneFilter); ?>
    </select>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Modelo</th>
            <th>Potencia</th>
            <th>Zona</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lamps as $lamp): ?>
            <tr>
                <td><?= $lamp->getId() ?></td>
                <td><?= $lamp->getName() ?></td>
                <td>
                    <?php if ($lamp->isOn()): ?>
                        <a href="changestatus.php?id=<?= $lamp->getId() ?>&status=0" class="on">🔆 ON</a>
                    <?php else: ?>
                        <a href="changestatus.php?id=<?= $lamp->getId() ?>&status=1" class="off">💡 OFF</a>
                    <?php endif; ?>
                </td>
                <td><?= $lamp->getModel() ?></td>
                <td><?= $lamp->getWattage() ?> W</td>
                <td><?= $lamp->getZone() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Potencia Total por Zona (solo encendidas)</h2>
<ul>
    <?php foreach ($powerPerZone as $zone): ?>
        <li><?= $zone['zone_name'] ?>: <?= $zone['totalPower'] ?> W</li>
    <?php endforeach; ?>
</ul>

</body>
</html>
