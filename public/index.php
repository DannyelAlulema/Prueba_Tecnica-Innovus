<?php

header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

include_once __DIR__ . '/../config/app.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

$router->dispatch($method, $uri);