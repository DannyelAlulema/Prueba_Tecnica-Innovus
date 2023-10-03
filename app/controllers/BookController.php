<?php

namespace App\Controllers;

use App\Models\Book;
use Core\AbstractController as Controller;

class BookController extends Controller
{
    public function index() {
        $book = new Book();
        $data = $book->all();

        $this->successResponse($data);
    }
    
    public function show($requestData, $id) {
        $book = new Book();
        $data = $book->find($id);

        $this->successResponse($data);
    }
    
    public function store($requestData) {
        $rules = [
            'title' => 'required',
            'author_id' => 'required|integer',
            'genre' => 'required',
            'publisher' => 'required',
            'publication_year' => 'required|integer',
            'description' => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $book = new Book();
        $rowCount = $book->save($requestData);
        
        if ($rowCount > 0)
            $this->successResponse("Se insertaron $rowCount registros correctamente.");
        else 
            $this->errorResponse("No se pudo insertar ningún registro.", 500);
    }

    public function update($requestData, $id) {
        $rules = [
            'title' => 'required',
            'author_id' => 'required|integer',
            'genre' => 'required',
            'publisher' => 'required',
            'publication_year' => 'required|integer',
            'description' => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $book = new Book();
        $updated = $book->update($id, $requestData);

        if ($updated)
            $this->successResponse("Se actualizó el registro correctamente.");
        else 
            $this->errorResponse("No se pudo actualizar el registro.", 500);
    }
    
    public function destroy($requestData, $id) {
        $book = new Book();
        $book->delete($id);

        $this->successResponse('Se elimino el libro con id ' . $id . ' exitosamente');
    }
}
