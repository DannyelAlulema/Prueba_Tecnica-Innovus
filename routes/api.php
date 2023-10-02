<?php

use Core\Router;
$router = new Router();

$router->get('/', 'HomeController@index');