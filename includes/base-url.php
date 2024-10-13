<?php
define('BASE_URL', (substr(dirname($_SERVER['PHP_SELF']), -1) === '/' || substr(dirname($_SERVER['PHP_SELF']), -1) === '\\') 
    ? dirname($_SERVER['PHP_SELF']) 
    : dirname($_SERVER['PHP_SELF']) . '/');
/* Agregar <?php echo BASE_URL?> cuando se utilice una ruta  */