<?php

namespace App\Controllers;

use App\Models\Author;
use Core\AbstractController as Controller;

class AuthorController extends Controller
{
    public function index() {
        $author = new Author();
        $data = $author->select(['authors.*', 'COUNT(books.id) as books'])
            ->join('books', 'authors.id', 'books.author_id', 'LEFT')
            ->groupBy('authors.id, authors.name, authors.biography')
        ->get();

        $this->successResponse($data);
    }
    
    public function show($requestData, $id) {
        $author = new Author();
        $data = $author->find($id);

        $this->successResponse($data);
    }
    
    public function store($requestData) {
        $rules = [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'biography' => 'required',
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $author = new Author();
        $rowCount = $author->save($requestData);
        
        if ($rowCount > 0)
            $this->successResponse("Se insertaron $rowCount registros correctamente.");
        else 
            $this->errorResponse("No se pudo insertar ningún registro.", 500);
    }

    public function update($requestData, $id) {
        $rules = [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'biography' => 'required',
        ];

        $validation = $this->validate($rules, $requestData);

        if (!$validation['isValid']) {
            $this->errorResponse($validation['errors'], 400);
            return;
        }

        $author = new Author();
        $updated = $author->update($id, $requestData);

        if ($updated)
            $this->successResponse("Se actualizó el registro correctamente.");
        else 
            $this->errorResponse("No se pudo actualizar el registro.", 500);
    }
    
    public function destroy($requestData, $id) {
        $author = new Author();
        $author->delete($id);

        $this->successResponse('Se elimino el autor con id ' . $id . ' exitosamente');
    }
}
