<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesRwModel extends Model
{
    protected $table = 'categories_rw';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title'];
}
