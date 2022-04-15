<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapterEnModel extends Model
{
    protected $table = "chapters_en";
    protected $primaryKey = "id";
    protected $allowedFields = ["category_id","title"];
}
