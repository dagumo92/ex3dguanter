<?php
spl_autoload_register(function ($className) {
    require_once "clases/$className.php";
});