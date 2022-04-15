<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryRw extends Model
{
    protected $table = "category_rw";
    protected $allowedFields = ["id","title"];
}
