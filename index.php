<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
session_start();

require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/vendor/globalFunction.php';

use App\Components\Router;
//require_once(ROOT . '/Components/Router.php');
//include_once ROOT . '/Components/Db.php';

$router = new Router();

$router->run();