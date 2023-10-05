<?php

namespace App\Controllers;

use App\Traits\TokenBlackList;
use Core\AbstractController as Controller;

use App\Models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    use TokenBlackList;

    public function login($requestData) {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $user = new User();
        $data = $user->where('username', $requestData['username'])->get();
        
        if (!$data) {
            $this->errorResponse('El nombre de usuario no esta registrado', 400);
            return;
        }

        $data = $data[0];
        $pass = password_verify($requestData['password'], $data['password']);

        if (!$pass) {
            $this->errorResponse('Contraseña incorrecta', 400);
            return;
        }
        
        $payload = [
            'id' => $data['id'],
            'role' => $data['role'],
            'created_at' => date("d-m-Y_h:i:s")
        ];

        $jwt = JWT::encode($payload, APP_KEY, 'HS256');

        $this->successResponse([
            'message' => 'Inicio de sesión correcto',
            'token' => $jwt
        ]);
    }
    
    public function logout() {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $this->addToBlacklistDatabase($token);

        $this->successResponse([
            'message' => 'Se cerro la sesión correctamente'
        ]);
    }

    public function verify()
    {
        $this->successResponse([]);
    }
}
