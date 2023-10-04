<?php

namespace App\Middlewares;

use Core\Responser;

class GuestMiddleware
{
    use Responser;

    public function handle()
    {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!empty($authorizationHeader)) {
            $this->errorResponse('Not Found', 404);
            die();
        }
    }
}
