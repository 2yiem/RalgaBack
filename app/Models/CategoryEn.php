<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryEn extends Model
{
    protected $table = "category_en";
    protected $allowedFields = ["id","title"];
}
