<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapterFrModel extends Model
{
    protected $table = "chapters_fr";
    protected $primaryKey = "id";
    protected $allowedFields = ["category_id", "title"];
}
