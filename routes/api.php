<?php

use App\Controllers\AuthController;
use App\Controllers\AuthorController;
use App\Controllers\BookController;
use App\Controllers\UserController;
use App\Controllers\HomeController;

use Core\Router;
$router = new Router();

$router->get('/', [ HomeController::class, 'index' ]);

$router->post('/login', [ AuthController::class, 'login' ]);
$router->post('/logout', [ AuthController::class, 'logout' ]);

$router->get('/authors', [ AuthorController::class, 'index' ]);
$router->get('/authors/{id}', [ AuthorController::class, 'show' ]);
$router->post('/authors', [ AuthorController::class, 'store' ]);
$router->put('/authors/{id}', [ AuthorController::class, 'update' ]);
$router->delete('/authors/{id}', [ AuthorController::class, 'destroy' ]);

$router->get('/books', [ BookController::class, 'index' ]);
$router->get('/books/{id}', [ BookController::class, 'show' ]);
$router->post('/books', [ BookController::class, 'store' ]);
$router->put('/books/{id}', [ BookController::class, 'update' ]);
$router->delete('/books/{id}', [ BookController::class, 'destroy' ]);

$router->get('/users', [ UserController::class, 'index' ]);
$router->get('/users/{id}', [ UserController::class, 'show' ]);
$router->post('/users', [ UserController::class, 'store' ]);
$router->put('/users/{id}', [ UserController::class, 'update' ]);
$router->delete('/users/{id}', [ UserController::class, 'destroy' ]);
