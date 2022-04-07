<?php

namespace App\Models;

use CodeIgniter\Model;

class Article extends Model
{
    protected $table = "article";
    protected $primaryKey = "id";
    protected $allowedFields = ["title", "chapterId", "sectionId", "sousSectionId"];
}
