<?php

use System\Core\Request;
use System\Core\Router;

include_once SYSTEM.'autoload.php';
include_once ROUTE.'route.php';
include_once SYSTEM.'core/common_functions.php';
include_once SYSTEM.'core/Nl_controller.php';

$app = new Nl_controller();
$route = new Router();
$route->render();
