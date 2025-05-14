<?php
require_once("autoload.php");

$lampId = $_GET['id'];
$newStatus = $_GET['status'];

$lighting = new Lighting();
$lighting->changeStatus($lampId, $newStatus);

header("Location: index.php");