<?php

namespace App\Controllers;

use Core\AbstractController as Controller;

class AuthController extends Controller
{
    public function login() {
        $this->successResponse('Holaa');
    }
    
    public function logout() {
        $this->successResponse('Holaa');
    }
}
