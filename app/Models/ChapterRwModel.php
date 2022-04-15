<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapterRwModel extends Model
{
    protected $table = "chapters_rw";
    protected $primaryKey = "id";
    protected $allowedFields = ["category_id", "title"];
}
