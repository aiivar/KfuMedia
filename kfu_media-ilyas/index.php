<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$start = microtime(true);

function autoload(string $className)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
}

spl_autoload_register('autoload');
require 'vendor/autoload.php';

$config = require "config/web.php";
(new App\App($config))->run();

$end = microtime(true);
echo $end - $start . ' seconds';