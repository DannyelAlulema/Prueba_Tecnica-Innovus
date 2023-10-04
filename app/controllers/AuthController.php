<?php

namespace App\Controllers;

use Core\AbstractController as Controller;

use App\Models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
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
            'name' => $data['name'],
            'role' => $data['role']
        ];

        $jwt = JWT::encode($payload, APP_KEY, 'HS256');

        $this->successResponse([
            'message' => 'Inicio de sesión correcto',
            'token' => $jwt
        ]);
    }
    
    public function logout() {
        $this->successResponse('Holaa');
    }
}
