<?php

namespace App\Middlewares;

use App\Traits\TokenBlackList;
use Core\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    use Responser, TokenBlackList;

    public function handle()
    {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $authorizationHeader);

        if (empty($token))
            $this->errorResponse('Acceso denegado, token no proporcionado.', 401);

        if (!$this->isValidJwt($token)) 
            $this->errorResponse('Token inválido.', 403);
        
        if ($this->isTokenBlacklisted($token))
            $this->errorResponse('Token inválido.', 401);

        $this->addDecodedJwtToRequest($token);
    }

    private function isValidJwt($token)
    {
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

    private function addDecodedJwtToRequest($token)
    {
        $decoded = JWT::decode($token, new Key(APP_KEY, 'HS256'));
        $_REQUEST['decoded_jwt'] = $decoded;
    }
}
