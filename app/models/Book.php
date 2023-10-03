<?php

namespace App\Models;

use Core\AbstractModel as Model;

class Book extends Model
{
    public public function __construct() {
        $fields = [
            'title',
            'author_id',
            'genre',
            'publisher',
            'publication_year',
            'description',
            'price',
            'stock',
        ];

        parent::__construct('books', $fields);
    }
}
