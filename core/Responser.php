<?php

namespace Core;

trait Responser
{
    public function successResponse($data)
    {
        echo json_encode(['data' => $data, 'code' => 200]);
        die();
    }
    
    public function errorResponse($message, $code)
    {
        echo json_encode(['error' => $message, 'code' => $code]);
        die();
    }
}
