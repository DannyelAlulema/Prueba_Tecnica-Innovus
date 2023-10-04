<?php

namespace App\Middlewares;
use Core\Responser;

class AdminMiddleware
{
    use Responser;

    public function handle() {
        if (!isset($_REQUEST['decoded_jwt'])) {
            $this->errorResponse('Not Found', 404);
            die();
        }

        $user = $_REQUEST['decoded_jwt'];

        if ($user->role != 'ADMIN') {
            $this->errorResponse('Not Found', 404);
            die();
        }
    }
}
