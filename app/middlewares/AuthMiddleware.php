<?php

namespace App\Middlewares;

use Core\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    use Responser;

    public function handle()
    {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$this->isValidJwt($authorizationHeader)) {
            $this->errorResponse('Not Found', 404);
            die();
        }

        $this->addDecodedJwtToRequest($authorizationHeader);
    }

    private function isValidJwt($authorizationHeader)
    {
        $token = str_replace('Bearer ', '', $authorizationHeader);

        if (!empty($token)) {
            try {
                $decoded = JWT::decode($token, new Key(APP_KEY, 'HS256'));
                
                if ($decoded)
                    return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    private function addDecodedJwtToRequest($authorizationHeader)
    {
        $token = str_replace('Bearer ', '', $authorizationHeader);
        
        $decoded = JWT::decode($token, new Key(APP_KEY, 'HS256'));
        $_REQUEST['decoded_jwt'] = $decoded;
    }
}
