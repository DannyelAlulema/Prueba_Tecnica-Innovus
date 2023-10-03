<?php

namespace App\Controllers;

use Core\AbstractController as Controller;

class HomeController extends Controller
{
    public function index() {
        $this->successResponse('API - Prueba tecnica Innovus (Dannyel Alulema)');
    }
}