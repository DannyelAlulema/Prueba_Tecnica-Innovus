<?php

namespace App\Controllers;

use App\Models\User;
use Core\AbstractController as Controller;

class UserController extends Controller
{
    public function index() {
        $user = new User();
        $data = $user->all();

        $this->successResponse($data);
    }
    
    public function show($id) {
        $user = new User();
        $data = $user->find($id);

        $this->successResponse($data);
    }
    
    public function store($requestData) {
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required'
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $user = new User();
        $rowCount = $user->save($requestData);
        
        if ($rowCount > 0)
            $this->successResponse("Se insertaron $rowCount registros correctamente.");
        else 
            $this->errorResponse("No se pudo insertar ningún registro.", 500);
    }

    public function update($requestData, $id) {
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required'
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $user = new User();
        $updated = $user->update($id, $requestData);

        if ($updated)
            $this->successResponse("Se actualizó el registro correctamente.");
        else 
            $this->errorResponse("No se pudo actualizar el registro.", 500);
    }
    
    public function destroy($id) {
        $user = new User();
        $user->delete($id);

        $this->successResponse('Se elimino el usuario con id ' . $id . ' exitosamente');
    }
}
