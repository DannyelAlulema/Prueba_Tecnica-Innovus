<?php

use Core\AbstractModel as Model;

class Author extends Model
{
    public function __construct() {
        $fiels = [
            'name',
            'biography'
        ];

        parent::__construct('authors', $fiels);
    }
}
