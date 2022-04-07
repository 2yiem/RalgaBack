<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapterModel extends Model
{
    protected $table = "chapter";
    protected $allowedFields = ["id", "title"];
}
