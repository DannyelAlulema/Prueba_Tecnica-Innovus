<?php

namespace App\Controllers;
use App\Traits\Responser;

class HomeController
{
    use Responser;
    
    public function index() {
        $this->successResponse('API - Prueba tecnica Innovus (Dannyel Alulema)');
    }
}