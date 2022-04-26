<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesFRModel extends Model
{
    protected $table = 'categories_fr';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title'];
}
