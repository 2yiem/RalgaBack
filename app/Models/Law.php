<?php

namespace App\Models;

use CodeIgniter\Model;

class Law extends Model
{
    protected $table = "laws";
    protected $allowedFields = ["id", "articleId", "chapterId", "title"];
    protected $useTimestamps = true;
}
