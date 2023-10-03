<?php

namespace App\Models;

use Core\AbstractModel as Model;

class User extends Model
{
    public function __construct() {
        $fields = [
            'username',
            'password',
            'name',
            'role'
        ];

        parent::__construct('users', $fields);
    }
}
