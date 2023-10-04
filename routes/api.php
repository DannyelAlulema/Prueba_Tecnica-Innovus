<?php

use App\Controllers\AuthController;
use App\Controllers\AuthorController;
use App\Controllers\BookController;
use App\Controllers\UserController;
use App\Controllers\HomeController;

use App\Middlewares\AdminMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

use Core\Router;
$router = new Router();

$router->get('/', [ HomeController::class, 'index' ]);

$router->post('/login', [ AuthController::class, 'login' ], [ GuestMiddleware::class ]);
$router->post('/logout', [ AuthController::class, 'logout' ], [ AuthMiddleware::class ]);

$router->get('/authors', [ AuthorController::class, 'index' ], [ AuthMiddleware::class ]);
$router->get('/authors/{id}', [ AuthorController::class, 'show' ], [ AuthMiddleware::class ]);
$router->post('/authors', [ AuthorController::class, 'store' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->put('/authors/{id}', [ AuthorController::class, 'update' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->delete('/authors/{id}', [ AuthorController::class, 'destroy' ], [ AuthMiddleware::class, AdminMiddleware::class ]);

$router->get('/books', [ BookController::class, 'index' ], [ AuthMiddleware::class ]);
$router->get('/books/{id}', [ BookController::class, 'show' ], [ AuthMiddleware::class ]);
$router->post('/books', [ BookController::class, 'store' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->put('/books/{id}', [ BookController::class, 'update' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->delete('/books/{id}', [ BookController::class, 'destroy' ], [ AuthMiddleware::class, AdminMiddleware::class ]);

$router->get('/users', [ UserController::class, 'index' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->get('/users/{id}', [ UserController::class, 'show' ], [ AuthMiddleware::class ]);
$router->post('/users', [ UserController::class, 'store' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->put('/users/{id}', [ UserController::class, 'update' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
$router->delete('/users/{id}', [ UserController::class, 'destroy' ], [ AuthMiddleware::class, AdminMiddleware::class ]);
